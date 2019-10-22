# SHAREP -SHAred REsources Platform API

Travis Build Status [![Travis Build Status](https://travis-ci.org/shareps/app.svg?branch=master)](https://travis-ci.org/shareps/app)

# Status
- General status: Early alpha version
- Technical side analyzed and developed, general idea known, functional side under development
- Ready to transform to working app

# Tasks
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
        
