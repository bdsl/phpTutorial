#!/usr/bin/env bash

set -x
set -e

if [[ $(cat *.md content/*.md | aspell --run-together --run-together-limit=3 --lang=en_GB.UTF-8 -p ./.spelling/wordlist list | sort | uniq ) ]]; then
  echo "Spelling issue found - check spellings of word(s) shown above. If words are correct add them to .spelling/wordlist"
  exit 1
fi
