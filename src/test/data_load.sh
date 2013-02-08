#!/bin/bash
php symfony doctrine:drop-db --env=test
php symfony doctrine:build-db --env=test
php symfony doctrine:insert-sql --env=test
php symfony doctrine:data-load --env=test
