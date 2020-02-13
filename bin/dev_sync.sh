#!/bin/bash

root="$(git rev-parse --show-toplevel)"

# shellcheck disable=SC1090,SC1091
source "$root/.env"

rsync -a "$BC_CANVAS_JSON_DIR" "$BC_CANVAS_TRACKED_DIR"
rsync -a --delete "$BC_CANVAS_TRACKED_DIR" "$BC_CANVAS_MU_PLUGIN_DIR"
