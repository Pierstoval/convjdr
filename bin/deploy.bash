#!/bin/bash

set -e

#     _
#    / \    Disclaimer!
#   / ! \   Please read this before continuing.
#  /_____\  Thanks ☺ ♥
#
# This is the deploy script used in production.
# It does plenty tasks:
#  * Run scripts that are mandatory after a deploy.
#  * Update RELEASE_VERSION and RELEASE_DATE environment vars,
#  * Save the values in env files for CLI and webserver.
#  * Send by email the analyzed changelog (which might not be 100% correct, but it's at least a changelog).

# bin/ directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Project directory
cd ${DIR}/../

DIR="$(pwd)"

echo "Working directory: ${DIR}"

ENV_FILE="./.env.local.php"
CHANGELOG_FILE=${DIR}/var/_tmp_changelog.txt

#LAST_VERSION=$(grep -o -E "'RELEASE_VERSION' *=> *'[0-9\.-]+'" ${ENV_FILE} | sed -r 's/[^0-9]+//g')
LAST_VERSION=$(php -r '$env = include ".env.local.php"; echo $env["RELEASE_VERSION"];')
NEW_VERSION=$(expr ${LAST_VERSION} + 1)

#LAST_DATE=$(grep -o -E "'RELEASE_DATE' *=> *'[^']+'" ${ENV_FILE} | sed -r "s/^.*=> *'([^']+)'.*$/\1/g")
LAST_DATE=$(php -r '$env = include ".env.local.php"; echo $env["RELEASE_DATE"];')
NEW_DATE=$(date --rfc-3339=seconds)

echo "[DEPLOY] > Current version: ${LAST_VERSION}"
echo "[DEPLOY] > Last build date: ${LAST_DATE}"

echo "[DEPLOY] > Update repository branch"

git fetch --all --prune

CHANGELOG=$(git changelog v${LAST_VERSION}...origin/main | sed 1d)
CHANGELOG_SIZE=$(echo "${CHANGELOG}" | wc -l)
CHANGELOG_SIZE_CHARS=$(echo "${CHANGELOG}" | wc -m)
if [ "${CHANGELOG_SIZE_CHARS}" -lt "1" ]; then
    echo "[DEPLOY] > ${CHANGELOG}"
    echo "[DEPLOY] > No new commit! Terminating..."
    exit 1
else
    echo "[DEPLOY] > Retrieved $((CHANGELOG_SIZE)) commits(s) in changelog:"
    echo "[DEPLOY] > ${CHANGELOG}"
fi

echo "[DEPLOY] > Applying these commits..."
git reset --hard origin/main

echo "[DEPLOY] > Done!"

echo "[DEPLOY] > Executing scripts..."
echo "[DEPLOY] > "

#
# These scripts are "wrapped" because they might have been updated between deploys.
# Only this "deploy.bash" script can't be updated, because it's executed on deploy.
# But having the scripts executed like this is a nice opportunity to update the scripts between deploys.
#
bash ./bin/deploy_scripts.bash

echo "[DEPLOY] > Done!"
echo "[DEPLOY] > Now updating environment vars..."
echo "[DEPLOY] > New version: ${NEW_VERSION}"
echo "[DEPLOY] > New build date: ${NEW_DATE}"

echo "RELEASE_VERSION=${NEW_VERSION}" > .env.prod.local
echo "RELEASE_DATE=v${NEW_VERSION}" >> .env.prod.local
composer dump-env prod
rm rm .env.prod.local

echo "[DEPLOY] > Now generating changelogs..."

echo "" > ${CHANGELOG_FILE}

echo "New version: v${NEW_VERSION}"    >> ${CHANGELOG_FILE}
echo "Released on: ${NEW_DATE}"        >> ${CHANGELOG_FILE}
echo ""                                >> ${CHANGELOG_FILE}
echo "List of all changes/commits:"    >> ${CHANGELOG_FILE}
echo "${CHANGELOG}"                    >> ${CHANGELOG_FILE}
echo ""                                >> ${CHANGELOG_FILE}

echo "[DEPLOY] > FULL CHANGELOG"
cat ${CHANGELOG_FILE}

if [[ -f "${DIR}/../post_deploy.bash" ]]
then
    echo "[DEPLOY] > Executing post-deploy scripts"
    bash ../post_deploy.bash ${NEW_VERSION} ${CHANGELOG_FILE}
fi

echo "[DEPLOY] > Tagging release..."
echo "[DEPLOY] > Pushing it to Git..."

git tag -s -F ${CHANGELOG_FILE} "v${NEW_VERSION}"
git push origin "v${NEW_VERSION}"

rm ${CHANGELOG_FILE}

echo "[DEPLOY] > Done!"
echo "[DEPLOY] > Deploy finished!"
