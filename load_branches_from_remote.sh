#!/usr/bin/env bash

# Delete all local branches and create all non-remote-tracking branches of a specified remote
#
# Usage: load_branches_from_remote.sh <remote-name>
#
# Example: load_branches_from_remote.sh origin

REMOTE=$1
echo "Loading all branches from the remote '$REMOTE' (all local branches are deleted)"
# Checking out orphan commit so it 's possible to delete current branch
# Create non-remote-tracking branches from selected remote
for REMOTE_BRANCH in $(git branch -r|grep $REMOTE/); do
    BRANCH=${REMOTE_BRANCH/$REMOTE\//$REMOTE\_}
    echo "Branch name: '$BRANCH', Remote: '$REMOTE', Remote Branch: '$REMOTE_BRANCH'"
    git branch -q $BRANCH $REMOTE_BRANCH
    git branch --unset-upstream $BRANCH
done
git checkout -f $REMOTE"_develop"

