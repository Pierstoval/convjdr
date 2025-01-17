#!/bin/bash

set -e

# bin/ directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Project directory
cd ${DIR}/../

DIR="$(pwd)"

echo "Working directory: ${DIR}"

echo "[DEPLOY] > Update repository branch"

git fetch --all --prune

echo "[DEPLOY] > Applying these commits..."
git merge origin/main

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

if [[ -f "${DIR}/../post_deploy.bash" ]]
then
    echo "[DEPLOY] > Executing post-deploy scripts"
    bash ../post_deploy.bash
fi

echo "[DEPLOY] > Tagging release..."
echo "[DEPLOY] > Pushing it to Git..."

VERSION=$(date --rfc-3339=seconds)

git tag -s -F "v${VERSION}" -m "v${VERSION}"
git push origin "v${VERSION}"

echo "[DEPLOY] > Done!"
echo "[DEPLOY] > Deploy finished!"
