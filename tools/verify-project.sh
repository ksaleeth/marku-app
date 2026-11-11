#!/usr/bin/env bash
# Run inside the generated Bubblewrap project folder (where app/build.gradle is).
# Read-only check for v2.0.1. Does not touch keystore or passwords.
set -u
ok(){ echo "  OK   $1"; }; bad(){ echo "  FAIL $1"; FAIL=1; }; FAIL=0
G=app/build.gradle; M=app/src/main/AndroidManifest.xml
[ -f "$G" ] && [ -f "$M" ] || { echo "Run this inside the TWA project folder."; exit 1; }
echo "MarkU v2.0.1 check"
grep -q "hostName: 'marku.in'" $G            && ok "hostName = marku.in"          || bad "hostName is not marku.in"
grep -q "launchUrl: '/dashboard/'" $G         && ok "launchUrl = /dashboard/"     || bad "launchUrl changed"
grep -q "applicationId \"in.marku.app\"" $G   && ok "applicationId = in.marku.app" || bad "applicationId wrong"
grep -q "compileSdkVersion 36" $G             && ok "compileSdk 36"               || bad "compileSdk is not 36"
grep -q "targetSdkVersion 36" $G              && ok "targetSdk 36"                || bad "targetSdk is not 36"
grep -q "versionCode 5$" $G                   && ok "versionCode 5"               || bad "versionCode is not 5"
grep -q 'versionName "2.0.1"' $G              && ok "versionName 2.0.1"           || bad "versionName is not 2.0.1"
grep -q "enableNotifications: true" $G        && ok "enableNotifications true"    || bad "notifications off"
grep -q "android.permission.POST_NOTIFICATIONS" $M && ok "POST_NOTIFICATIONS"     || bad "POST_NOTIFICATIONS missing"
grep -q "NotificationPermissionRequestActivity" $M && ok "permission prompt activity" || bad "NotificationPermissionRequestActivity missing"
grep -q "ic_notification_icon" $M             && ok "notification small icon"     || bad "notification icon missing"
[ $FAIL = 0 ] && echo "All good. Ready to build." || echo "Fix FAIL items before building."
