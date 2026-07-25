#!/usr/bin/env bash
#
# Downloads the openly-licensed webfonts into public/fonts/.
#
#   Poppins    (OFL) — Latin, used by the `en` locale
#   Vazirmatn  (OFL) — Arabic/Persian, fallback for `fa` and `ar`
#
# Doran FaNum is commercially licensed and is NOT fetched here. Place the
# licensed .woff2 files in public/fonts/doran/ — see docs/ASSET-MANIFEST.md §10.

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
POPPINS_DIR="$ROOT/public/fonts/poppins"
VAZIR_DIR="$ROOT/public/fonts/vazirmatn"

mkdir -p "$POPPINS_DIR" "$VAZIR_DIR" "$ROOT/public/fonts/doran"

echo "==> Poppins"
POPPINS_BASE="https://raw.githubusercontent.com/google/fonts/main/ofl/poppins"
for weight in Regular Medium SemiBold Bold; do
  echo "    Poppins-$weight"
  curl -fsSL "$POPPINS_BASE/Poppins-$weight.ttf" -o "$POPPINS_DIR/Poppins-$weight.ttf"
done

echo "==> Vazirmatn"
VAZIR_VERSION="v33.003"
VAZIR_URL="https://github.com/rastikerdar/vazirmatn/releases/download/$VAZIR_VERSION/vazirmatn-$VAZIR_VERSION.zip"
TMP="$(mktemp -d)"
curl -fsSL "$VAZIR_URL" -o "$TMP/vazirmatn.zip"
unzip -qo "$TMP/vazirmatn.zip" -d "$TMP"
find "$TMP" -name 'Vazirmatn-Regular.woff2' -exec cp {} "$VAZIR_DIR/" \;
find "$TMP" -name 'Vazirmatn-Medium.woff2'  -exec cp {} "$VAZIR_DIR/" \;
find "$TMP" -name 'Vazirmatn-Bold.woff2'    -exec cp {} "$VAZIR_DIR/" \;
rm -rf "$TMP"

echo
echo "==> Converting Poppins TTF -> WOFF2"
if command -v woff2_compress >/dev/null 2>&1; then
  for f in "$POPPINS_DIR"/*.ttf; do
    woff2_compress "$f" && rm "$f"
  done
  echo "    done"
else
  echo "    woff2_compress not found."
  echo "    Install it:  brew install woff2   |   apt-get install woff2"
  echo "    Then re-run this script."
  exit 1
fi

echo
echo "Fonts installed."
echo "Reminder: Doran FaNum must be supplied separately (docs/ASSET-MANIFEST.md §10)."
