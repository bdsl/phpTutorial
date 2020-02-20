#!/usr/bin/env bash

set -x
set -e

if [[ $(cat *.md content/*.md | aspell --lang=en_GB.UTF-8 -p ./.spelling/wordlist list | sort | uniq ) ]]; then
  exit 1
fi
