#!/usr/bin/env bash

docker run --rm \
  -v "$(pwd)":/workspace \
  plantuml/plantuml \
  -tsvg /workspace/$1
