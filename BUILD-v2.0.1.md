# MarkU v2.0.1 (versionCode 5) — Build Guide

Package: `in.marku.app` · Host: `marku.in` · Start: `/dashboard/`
Bubblewrap CLI **1.27.0** (targetSdk / compileSdk **36**, androidbrowserhelper 2.7.4)

> Keystore `android-new2.keystore`-ഉം പാസ്‌വേഡും ഈ ഫയലുകളിൽ ഇല്ല, തൊട്ടിട്ടുമില്ല.
> ബാക്കപ്പ്: `backups/2026-11-11-v2.0.1/twa-manifest.json.bak`

## 0. ബാക്കപ്പ് (ലോക്കൽ പ്രോജക്റ്റ് ഫോൾഡറിൽ)
```bash
cd <MarkU-TWA-folder>
mkdir -p ../markU-backup-v1 && cp -r . ../markU-backup-v1/
```

## 1. Bubblewrap അപ്ഡേറ്റ്
```bash
npm install -g @bubblewrap/cli@1.27.0
bubblewrap doctor
```

## 2. പുതിയ ഐക്കണുകൾ (ഒരിക്കൽ മാത്രം)
```bash
pip install pillow
python3 tools/make-icons.py MarkU-logo-transparent.png icons-out
```
`icons-out/`-ലെ 3 ഫയലുകൾ WordPress Media-യിൽ അപ്‌ലോഡ് ചെയ്യുക. URL-കൾ `twa-manifest.json`-ൽ ഇടുക:
- `iconUrl` → markU-icon-512.png
- `maskableIconUrl` → markU-maskable-512.png
- `monochromeIconUrl` → markU-monochrome-96.png

## 3. twa-manifest.json
ഈ repo-യിലെ `twa-manifest.json`-ലെ മാറ്റങ്ങൾ ലോക്കൽ ഫയലിലേക്ക് കോപ്പി ചെയ്യുക
(`enableNotifications`, `appVersion`, `appVersionCode`, `fingerprints`, icon URLs).
ലോക്കൽ ഫയലിലെ `signingKey` (path, alias) **മാറ്റരുത്**.

## 4. പ്രോജക്റ്റ് റീജനറേറ്റ് (versionCode 5 നിലനിർത്തി)
```bash
bubblewrap update --skipVersionUpgrade
```

## 5. പരിശോധന
```bash
bash tools/verify-project.sh
```
എല്ലാം `OK` ആയാൽ മാത്രം അടുത്ത ഘട്ടം.

## 6. ബിൽഡ് (നിങ്ങളുടെ അനുമതിയോടെ, നിങ്ങൾ തന്നെ)
```bash
bubblewrap build
```
കീസ്റ്റോർ പാസ്‌വേഡ് ചോദിക്കുമ്പോൾ നിങ്ങൾ ടൈപ്പ് ചെയ്യുക.
Output: `app-release-bundle.aab` → Play Console → Production → Create new release.

## 7. ടെസ്റ്റ്
- Internal testing വഴി Play-ൽ നിന്ന് ഇൻസ്റ്റാൾ ചെയ്യുക (sideload അല്ല).
- അഡ്രസ് ബാർ ഇല്ലെന്ന് ഉറപ്പാക്കുക.
- Android 13+: ആദ്യം "Allow MarkU to send you notifications?" വരണം → Allow.
- marku.in-ൽ നിന്ന് test push അയച്ച് നോക്കുക.
