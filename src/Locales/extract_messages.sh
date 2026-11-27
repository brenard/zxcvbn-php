#!/bin/bash

which xgettext &>/dev/null || { echo "xgettext not found, please install it"; exit 1; }
which msgfmt &>/dev/null || { echo "msgfmt not found, please install it"; exit 1; }

cd -- "$( dirname -- "$0" )/../"

find -name '*.php' | xgettext \
      --from-code utf-8 \
      --language=PHP \
      -o Locales/zxcvbn-php.pot \
      --files=-

[ $? -eq 0 ] && echo "Locales/zxcvbn-php.pot file updated"

# Regenerate .mo files from .po
find . -name '*.po' | \
    xargs -I {} sh -c \
    'pofile="{}"; echo "update ${pofile%.po}.mo"; msgfmt "${pofile}" -o "${pofile%.po}.mo"'
