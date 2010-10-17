#!/bin/sh
if [ -z "$RABBITPHP_HOME" ]; then
   RABBITPHP_HOME=/home/kerrywilson/rabbitphp.org
fi

cd $RABBITPHP_HOME
tar -cf "$RABBITPHP_HOME/dist/rabbitphp-$1.tar" ./{LICENSE,TODO,bin,build,docs,examples,lib}
gzip -f "$RABBITPHP_HOME/dist/rabbitphp-$1.tar"
