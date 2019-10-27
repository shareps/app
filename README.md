# SHAREP -SHAred REsources Platform API

Travis
[![Travis Build Status](https://travis-ci.org/shareps/app.svg?branch=master)](https://travis-ci.org/shareps/app)

CodeClimate
[![Maintainability](https://api.codeclimate.com/v1/badges/43183c33cd086bdd6f6c/maintainability)](https://codeclimate.com/github/shareps/app/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/43183c33cd086bdd6f6c/test_coverage)](https://codeclimate.com/github/shareps/app/test_coverage)

Scrutinizer
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/shareps/app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/shareps/app/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/shareps/app/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/shareps/app/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/shareps/app/badges/build.png?b=master)](https://scrutinizer-ci.com/g/shareps/app/build-status/master)

SonarCloud
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=shareps_app&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=shareps_app)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=shareps_app&metric=sqale_index)](https://sonarcloud.io/dashboard?id=shareps_app)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=shareps_app&metric=coverage)](https://sonarcloud.io/dashboard?id=shareps_app)

## Status

- General status: Early alpha version
- Technical side analyzed and developed, general idea known, functional side under development
- Ready to transform to working app

## Tasks

- [ ] Docker
    - [ ] Replace supervisord?
    - [ ] Helmet/Kubernetes?

- [ ] Technical
    - [ ] Tests to phar?
    - [ ] Test environment?
    - [ ] PHP Profiler
    - [ ] Message Queue
    - [ ] Tasks as plugins

- [ ] Framework
    - [ ] Logs
        - [x] File
        - [ ] Kibana/Greylog
        - [ ] Database
            - [ ] HTTP Requests
            - [ ] API Requests
            - [ ] Commands
            - [ ] DB Queries?
            - [ ] Stopwatch

- [ ] Access
    - [ ] Authentication
        - [x] Google Account
            - [ ] Invitation flow
            - [ ] Limit by Email Domain
        - [x] Slack Account
            - [ ] Invitation flow
            - [ ] Limit by Email Domain
    - [ ] Authorization
        - [ ] API
            - [x] Roles
            - [x] Permissions
            - [x] Voters
        - [ ] HTTP
            - [ ] Roles
            - [ ] Permissions
            - [ ] Voters
        - [ ] Slack
            - [ ] Roles
            - [ ] Permissions
            - [ ] Voters

- [ ] Create Account
    - [ ] Command
        - [x] Manager User
        - [ ] Invitation Email
        - [ ] Limit by Email Domain

- [ ] Accounting
    - [x] Double Entry system
    - [ ] Wallets

- [ ] Resources
    - [ ] Spaces
        - [x] Spaces availability
            - [ ] Edit
        - [x] Holidays
            - [ ] Edit
    - [ ] Member
        - [ ] User functionality
        - [ ] Add Member
            - [ ] Invitation Email
        - [ ] Edit Member
        - [ ] Enable/Disable Member
        - [ ] Remove Member (Disable/Encode)
    - [ ] Member Needs
        - [ ] Vacations
        - [ ] Very needed reservation
    - [ ] Membership
        - [ ] Member availability
        - [ ] Edit
    - [ ] Reservations
        - [ ] Revoked/Assigned
        - [ ] Rules

- [ ] Parking Rules
    - [x] Points
    - [x] Points per space
    - [ ] Reservation revoke
        - [ ] Points
        - [ ] Rules
    - [ ] Reservation assignment
        - [ ] Points
        - [ ] Rules

- [ ] Tasks
    - [ ] Configuration
    - [ ] Cron

- [ ] Slack
    - [ ] Command
        - [ ] Revoke reservation
        - [ ] Take reservation
    - [ ] Component
    - [ ] Event
