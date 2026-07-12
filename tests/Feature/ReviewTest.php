<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                              */
    /* ------------------------------------------------------------------ */

    private function makeProduct(): Product
    {
        $category = Category::create([
            'name'      => 'تست',
            'slug'      => 'test-cat-' . uniqid(),
            'is_active' => true,
        ]);

        $brand = \App\Models\Brand::create([
            'name' => 'برند تست',
            'slug' => 'test-brand-' . uniqid(),
        ]);

        return Product::create([
            'name'        => 'محصول تست',
            'slug'        => 'test-product-' . uniqid(),
            'description' => 'توضیحات',
            'price'       => 100000,
            'stock'       => 10,
            'is_active'   => true,
            'category_id' => $category->id,
            'brand_id'    => $brand->id,
        ]);
    }

    private function makeUser(bool $admin = false): User
    {
        return User::create([
            'name'     => 'کاربر تست',
            'email'    => 'test-' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'is_admin' => $admin,
        ]);
    }

    private function makeDeliveredOrderForUser(User $user, Product $product): OrderItem
    {
        $order = Order::create([
            'user_id'     => $user->id,
            'name'        => $user->name,
            'phone'       => '09000000000',
            'address'     => 'آدرس تست',
            'city'        => 'لنگرود',
            'total_price' => $product->price,
            'status'      => 'delivered',
        ]);

        return OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'price'        => $product->price,
            'quantity'     => 1,
            'total_price'  => $product->price,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  1. Guest cannot submit                                               */
    /* ------------------------------------------------------------------ */

    public function test_guest_cannot_submit_review(): void
    {
        $product = $this->makeProduct();

        $response = $this->post(route('reviews.store', $product->slug), [
            'rating' => 5,
            'body'   => 'نظر آزمایشی بیشتر از ده کاراکتر',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('reviews', 0);
    }

    /* ------------------------------------------------------------------ */
    /*  2. Authenticated user can submit                                     */
    /* ------------------------------------------------------------------ */

    public function test_authenticated_user_can_submit_review(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $response = $this->actingAs($user)->post(route('reviews.store', $product->slug), [
            'rating' => 4,
            'title'  => 'عنوان نظر',
            'body'   => 'این محصول واقعاً عالی است و کیفیت خوبی دارد.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'rating'     => 4,
            'is_approved' => false,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  3. Invalid rating fails validation                                   */
    /* ------------------------------------------------------------------ */

    public function test_invalid_rating_fails_validation(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $response = $this->actingAs($user)->post(route('reviews.store', $product->slug), [
            'rating' => 9,   // out of 1-5
            'body'   => 'محصول خوبی است.',
        ]);

        $response->assertSessionHasErrors('rating');
        $this->assertDatabaseCount('reviews', 0);
    }

    /* ------------------------------------------------------------------ */
    /*  4. Duplicate review is rejected                                      */
    /* ------------------------------------------------------------------ */

    public function test_user_cannot_submit_duplicate_review(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'rating'               => 3,
            'body'                 => 'نظر اول که قبلاً ثبت شده است.',
            'is_approved'          => false,
            'is_verified_purchase' => false,
        ]);

        $response = $this->actingAs($user)->post(route('reviews.store', $product->slug), [
            'rating' => 5,
            'body'   => 'تلاش برای ثبت نظر دوم که نباید انجام شود.',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('reviews', 1);
    }

    /* ------------------------------------------------------------------ */
    /*  5. Unapproved review is hidden on product page                       */
    /* ------------------------------------------------------------------ */

    public function test_unapproved_review_is_hidden_publicly(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'rating'               => 5,
            'title'                => 'نظر پنهان',
            'body'                 => 'این نظر هنوز تأیید نشده است.',
            'is_approved'          => false,
            'is_verified_purchase' => false,
        ]);

        $response = $this->get(route('products.show', $product->slug));
        $response->assertStatus(200);
        $response->assertDontSee('نظر پنهان');
    }

    /* ------------------------------------------------------------------ */
    /*  6. Admin can approve a review                                        */
    /* ------------------------------------------------------------------ */

    public function test_admin_can_approve_review(): void
    {
        $admin   = $this->makeUser(admin: true);
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $review = Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'rating'               => 4,
            'body'                 => 'نظر معمولی در انتظار تأیید.',
            'is_approved'          => false,
            'is_verified_purchase' => false,
        ]);

        $this->actingAs($admin)
             ->post(route('admin.reviews.approve', $review))
             ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id'          => $review->id,
            'is_approved' => true,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  7. Admin can reject (un-approve) a review                           */
    /* ------------------------------------------------------------------ */

    public function test_admin_can_reject_review(): void
    {
        $admin   = $this->makeUser(admin: true);
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $review = Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'rating'               => 2,
            'body'                 => 'نظری که باید رد شود.',
            'is_approved'          => true,
            'is_verified_purchase' => false,
            'approved_at'          => now(),
        ]);

        $this->actingAs($admin)
             ->post(route('admin.reviews.reject', $review))
             ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id'          => $review->id,
            'is_approved' => false,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  8. Approved review appears publicly                                  */
    /* ------------------------------------------------------------------ */

    public function test_approved_review_appears_publicly(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'rating'               => 5,
            'title'                => 'نظر تأیید شده',
            'body'                 => 'این محصول بسیار مناسب است.',
            'is_approved'          => true,
            'is_verified_purchase' => false,
            'approved_at'          => now(),
        ]);

        $response = $this->get(route('products.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('نظر تأیید شده');
    }

    /* ------------------------------------------------------------------ */
    /*  9. Verified purchase badge is set when order exists                  */
    /* ------------------------------------------------------------------ */

    public function test_verified_purchase_flag_is_set_when_user_has_purchased(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $this->makeDeliveredOrderForUser($user, $product);

        $this->actingAs($user)->post(route('reviews.store', $product->slug), [
            'rating' => 5,
            'body'   => 'محصول عالی بود و کاملاً ارزش خرید دارد.',
        ]);

        $this->assertDatabaseHas('reviews', [
            'user_id'              => $user->id,
            'product_id'           => $product->id,
            'is_verified_purchase' => true,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  10. Body too short fails validation                                  */
    /* ------------------------------------------------------------------ */

    public function test_body_shorter_than_minimum_fails(): void
    {
        $user    = $this->makeUser();
        $product = $this->makeProduct();

        $response = $this->actingAs($user)->post(route('reviews.store', $product->slug), [
            'rating' => 3,
            'body'   => 'کوتاه',   // < 10 chars
        ]);

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('reviews', 0);
    }
}
