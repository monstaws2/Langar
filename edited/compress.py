"""
compress.py — LangarMotor image compressor + renamer
Finds every photo inside each product folder (including nested
sub-folders like 'edited'), compresses it to WebP, then renames it
to match its product folder name with a number, e.g. honda(1).webp.
Old files are deleted ONLY after compression succeeds for that whole
product folder — nothing is deleted if any photo fails.
"""

import os
from PIL import Image

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
IMAGE_EXTENSIONS = (".jpg", ".jpeg", ".png", ".webp")

# ── Settings you can adjust ─────────────────────────────────────────
MAX_DIMENSION = 1600
WEBP_QUALITY = 82

# Files/folders in your main directory that are NOT products, so they
# get skipped entirely. Add any others you have (check the exact name).
EXCLUDE_NAMES = {
    "compress.py", "edit.py", "products_import.xlsx",
    "logo.jpg", ".git", "__pycache__",
    "github.com_monstaws2_langar",  # adjust to your real folder name
}


def compress_image(input_path, output_path):
    """Opens one image, shrinks it if too large, saves as WebP."""
    with Image.open(input_path) as img:
        if img.mode not in ("RGB", "RGBA"):
            img = img.convert("RGBA" if "A" in img.mode else "RGB")
        if max(img.size) > MAX_DIMENSION:
            ratio = MAX_DIMENSION / max(img.size)
            new_size = (int(img.width * ratio), int(img.height * ratio))
            img = img.resize(new_size, Image.LANCZOS)
        img.save(output_path, "WEBP", quality=WEBP_QUALITY, method=6)


def main():
    print("=" * 60)
    print("LangarMotor Image Compressor + Renamer — starting up")
    print("=" * 60)

    product_folders = sorted([
        f for f in os.listdir(BASE_DIR)
        if os.path.isdir(os.path.join(BASE_DIR, f))
        and f.lower() not in {n.lower() for n in EXCLUDE_NAMES}
    ])

    if not product_folders:
        print("No product folders found. Check EXCLUDE_NAMES.")
        return

    total_before = 0
    total_after = 0
    total_images = 0

    for product_name in product_folders:
        product_path = os.path.join(BASE_DIR, product_name)

        # Find EVERY photo in this product folder, including sub-folders
        original_paths = []
        for root, dirs, files in os.walk(product_path):
            for fname in sorted(files):
                if fname.lower().endswith(IMAGE_EXTENSIONS):
                    original_paths.append(os.path.join(root, fname))
        original_paths.sort()

        if not original_paths:
            print(f"\n📁 {product_name}: no images found, skipping.")
            continue

        print(f"\n📁 Product: {product_name} ({len(original_paths)} photo(s) found)")

        # Step 1: Compress everything into TEMPORARY files first
        temp_outputs = []
        compression_ok = True

        for idx, in_path in enumerate(original_paths, start=1):
            temp_out_path = os.path.join(product_path, f"__tmp_{idx}.webp")
            try:
                before_size = os.path.getsize(in_path)
                compress_image(in_path, temp_out_path)
                after_size = os.path.getsize(temp_out_path)
                temp_outputs.append((temp_out_path, before_size, after_size))
            except Exception as e:
                print(f"  ❌ Error compressing "
                      f"{os.path.relpath(in_path, product_path)}: {e}")
                compression_ok = False
                break

        # Step 2: If ANYTHING failed, clean up temp files and skip this
        # folder completely — original photos stay 100% untouched.
        if not compression_ok:
            print("  ⚠️  Skipping this folder — nothing was deleted or renamed.")
            for temp_path, _, _ in temp_outputs:
                if os.path.exists(temp_path):
                    os.remove(temp_path)
            continue

        # Step 3: All compressions succeeded — now it's safe to delete originals
        for in_path in original_paths:
            os.remove(in_path)

        # Step 4: Remove now-empty sub-folders like "edited"
        for root, dirs, files in os.walk(product_path, topdown=False):
            if root != product_path and not os.listdir(root):
                os.rmdir(root)

        # Step 5: Rename temp files to final names: product_name(1).webp, etc.
        for idx, (temp_path, before_size, after_size) in enumerate(temp_outputs, start=1):
            final_name = f"{product_name}({idx}).webp"
            final_path = os.path.join(product_path, final_name)
            os.rename(temp_path, final_path)

            total_before += before_size
            total_after += after_size
            total_images += 1

            saved_pct = (1 - after_size / before_size) * 100 if before_size else 0
            print(f"  ✅ Saved as {final_name}: {before_size/1024:.0f}KB → "
                  f"{after_size/1024:.0f}KB ({saved_pct:.0f}% smaller)")

    print("\n" + "=" * 60)
    if total_images == 0:
        print("No images were processed.")
    else:
        total_saved_pct = (1 - total_after / total_before) * 100 if total_before else 0
        print(f"Done! Compressed and renamed {total_images} photo(s) across "
              f"{len(product_folders)} folder(s).")
        print(f"Total size before: {total_before/1024/1024:.2f} MB")
        print(f"Total size after:  {total_after/1024/1024:.2f} MB")
        print(f"Overall saved: {total_saved_pct:.1f}%")
    print("=" * 60)


if __name__ == "__main__":
    main()