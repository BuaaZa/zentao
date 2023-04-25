create table if not exists zt_account
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    type        varchar(255)                not null,
    provider    varchar(255)                not null,
    adminURI    varchar(255)                not null,
    account     varchar(255)                not null,
    password    varchar(255)                not null,
    email       varchar(255)                not null,
    mobile      varchar(255)                not null,
    extra       text                        not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    status      varchar(30)                 not null,
    deleted     enum ('0', '1') default '0' not null
);

create index `name`
    on `zt_account` (`name`);

create index provider
    on zt_account (provider);

create index status
    on zt_account (status);

create table if not exists zt_acl
(
    id         int auto_increment
        primary key,
    account    char(30)                     not null,
    objectType char(30)                     not null,
    objectID   int      default 0           not null,
    type       char(40) default 'whitelist' not null,
    source     char(30)                     not null
);

create table if not exists zt_action
(
    id          int unsigned auto_increment
        primary key,
    objectType  varchar(30)     default ''    not null,
    objectID    int unsigned    default '0'   not null,
    product     text                          not null,
    project     int unsigned                  not null,
    execution   int unsigned                  not null,
    actor       varchar(100)    default ''    not null,
    exportDate  datetime                      not null,
    commentExId varchar(36)     default ''    not null,
    ip          char(15)        default ''    not null,
    action      varchar(80)     default ''    not null,
    date        datetime                      not null,
    comment     text                          not null,
    extra       text                          null,
    `read`      enum ('0', '1') default '0'   not null,
    vision      varchar(10)     default 'rnd' not null,
    efforted    int             default 0     not null
);

create index action
    on zt_action (action);

create index actor
    on zt_action (actor);

create index date
    on zt_action (date);

create index objectID
    on zt_action (objectID);

create index project
    on zt_action (project);

create table if not exists zt_actionarchive
(
    id         int unsigned auto_increment
        primary key,
    objectType varchar(30)     default ''    not null,
    objectID   int unsigned    default '0'   not null,
    product    text                          not null,
    project    int unsigned                  not null,
    execution  int unsigned                  not null,
    actor      varchar(100)    default ''    not null,
    ip         char(15)        default ''    not null,
    action     varchar(80)     default ''    not null,
    date       datetime                      not null,
    comment    text                          not null,
    extra      text                          null,
    `read`     enum ('0', '1') default '0'   not null,
    vision     varchar(10)     default 'rnd' not null,
    efforted   int             default 0     not null
);

create index action
    on zt_actionarchive (action);

create index actor
    on zt_actionarchive (actor);

create index date
    on zt_actionarchive (date);

create index objectID
    on zt_actionarchive (objectID);

create index project
    on zt_actionarchive (project);

create table if not exists zt_activity
(
    id           int unsigned auto_increment
        primary key,
    process      int                         not null,
    name         varchar(255)                not null,
    optional     varchar(255)                not null,
    tailorNorm   varchar(255)                not null,
    content      mediumtext                  not null,
    assignedTo   varchar(30)                 not null,
    status       varchar(30)                 not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    assignedBy   varchar(30)                 not null,
    assignedDate datetime                    not null,
    `order`      int             default 0   null,
    deleted      enum ('0', '1') default '0' not null
);

create table if not exists zt_api
(
    id              int unsigned auto_increment
        primary key,
    product         varchar(255)    default ''  not null,
    lib             int unsigned    default '0' not null,
    module          int unsigned    default '0' not null,
    title           varchar(100)    default ''  not null,
    path            varchar(255)    default ''  not null,
    protocol        varchar(10)     default ''  not null,
    method          varchar(10)     default ''  not null,
    requestType     varchar(100)    default ''  not null,
    responseType    varchar(100)    default ''  not null,
    status          varchar(20)     default ''  not null,
    owner           varchar(30)     default '0' not null,
    `desc`          mediumtext                  null,
    version         int unsigned    default '0' not null,
    params          text                        null,
    paramsExample   text                        null,
    responseExample text                        null,
    response        text                        null,
    commonParams    text                        null,
    addedBy         varchar(30)     default '0' not null,
    addedDate       datetime                    not null,
    editedBy        varchar(30)     default '0' not null,
    editedDate      datetime                    not null,
    deleted         enum ('0', '1') default '0' not null
);

create table if not exists zt_apispec
(
    id              int unsigned auto_increment
        primary key,
    doc             int unsigned default '0' not null,
    module          int unsigned default '0' not null,
    title           varchar(100) default ''  not null,
    path            varchar(255) default ''  not null,
    protocol        varchar(10)  default ''  not null,
    method          varchar(10)  default ''  not null,
    requestType     varchar(100) default ''  not null,
    responseType    varchar(100) default ''  not null,
    status          varchar(20)  default ''  not null,
    owner           varchar(255) default '0' not null,
    `desc`          mediumtext               null,
    version         int unsigned default '0' not null,
    params          text                     null,
    paramsExample   text                     null,
    responseExample text                     null,
    response        text                     null,
    addedBy         varchar(30)  default '0' not null,
    addedDate       datetime                 null
);

create table if not exists zt_apistruct
(
    id         int unsigned auto_increment
        primary key,
    lib        int unsigned    default '0' not null,
    name       varchar(30)     default ''  not null,
    type       varchar(50)     default ''  not null,
    `desc`     mediumtext                  not null,
    version    int unsigned    default '0' not null,
    attribute  text                        null,
    addedBy    varchar(30)     default '0' not null,
    addedDate  datetime                    not null,
    editedBy   varchar(30)     default '0' not null,
    editedDate datetime                    not null,
    deleted    enum ('0', '1') default '0' not null
);

create table if not exists zt_apistruct_spec
(
    id        int unsigned auto_increment
        primary key,
    name      varchar(255) default ''  not null,
    type      varchar(50)  default ''  not null,
    `desc`    varchar(255) default ''  not null,
    attribute text                     null,
    version   int unsigned default '0' not null,
    addedBy   varchar(30)  default '0' not null,
    addedDate datetime                 not null
);

create table if not exists zt_api_lib_release
(
    id        int unsigned auto_increment
        primary key,
    lib       int unsigned default '0' not null,
    `desc`    varchar(255) default ''  not null,
    version   varchar(255) default ''  not null,
    snap      mediumtext               not null,
    addedBy   varchar(30)  default '0' not null,
    addedDate datetime                 not null
);

create table if not exists zt_approval
(
    id          int auto_increment
        primary key,
    flow        int                         not null,
    objectType  varchar(30)                 not null,
    objectID    int                         not null,
    nodes       mediumtext                  not null,
    version     int                         not null,
    status      varchar(20) default 'doing' not null,
    result      varchar(20)                 not null,
    createdBy   char(30)                    not null,
    createdDate datetime                    not null,
    deleted     int         default 0       not null
);

create table if not exists zt_approvalflow
(
    id          int auto_increment
        primary key,
    name        varchar(255)  not null,
    code        varchar(100)  not null,
    `desc`      mediumtext    not null,
    version     int default 1 not null,
    createdBy   varchar(30)   not null,
    createdDate datetime      not null,
    type        varchar(30)   not null,
    deleted     int default 0 not null
);

create table if not exists zt_approvalflowobject
(
    id         int auto_increment
        primary key,
    root       int          not null,
    flow       int          not null,
    objectType char(30)     not null,
    objectID   int          not null,
    extra      varchar(255) not null
);

create table if not exists zt_approvalflowspec
(
    id          int auto_increment
        primary key,
    flow        int         not null,
    version     int         not null,
    nodes       mediumtext  not null,
    createdBy   varchar(30) not null,
    createdDate datetime    not null
);

create table if not exists zt_approvalnode
(
    id           int auto_increment
        primary key,
    approval     int                                 not null,
    type         enum ('review', 'cc')               not null,
    title        varchar(255)                        not null,
    account      char(30)                            not null,
    node         varchar(100)                        not null,
    reviewType   varchar(100)       default 'manual' not null,
    multipleType enum ('and', 'or') default 'and'    not null,
    prev         mediumtext                          not null,
    next         mediumtext                          not null,
    status       varchar(20)        default 'wait'   not null,
    result       varchar(10)                         not null,
    date         date                                not null,
    opinion      mediumtext                          not null,
    extra        mediumtext                          not null,
    reviewedBy   char(30)                            not null,
    reviewedDate datetime                            not null
);

create index idx_reviewed_date
    on zt_approvalnode (reviewedDate);

create table if not exists zt_approvalobject
(
    id         int auto_increment
        primary key,
    approval   int          not null,
    objectType char(30)     not null,
    objectID   int          not null,
    extra      varchar(255) not null
);

create table if not exists zt_approvalrole
(
    id      int auto_increment
        primary key,
    code    char(30)                    not null,
    name    varchar(255)                not null,
    `desc`  text                        not null,
    users   longtext                    not null,
    deleted enum ('0', '1') default '0' not null
);

create table if not exists zt_asset
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    status      varchar(30)                 not null,
    type        varchar(30)                 not null,
    `group`     varchar(128)                not null,
    createdBy   char(30)                    not null,
    createdDate datetime                    not null,
    editedBy    char(30)                    not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_assetlib
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    type        varchar(255)                not null,
    `desc`      mediumtext                  not null,
    `order`     int unsigned    default '0' not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_attend
(
    id           int unsigned auto_increment
        primary key,
    account      char(30)               not null,
    date         date                   not null,
    signIn       time                   not null,
    signOut      time                   not null,
    status       varchar(30) default '' not null,
    ip           varchar(15)            not null,
    device       varchar(30)            not null,
    client       varchar(20)            not null,
    manualIn     time                   not null,
    manualOut    time                   not null,
    reason       varchar(30) default '' not null,
    `desc`       text                   not null,
    reviewStatus varchar(30) default '' not null,
    reviewedBy   char(30)               not null,
    reviewedDate datetime               not null,
    constraint attend
        unique (date, account)
);

create index account
    on zt_attend (account);

create index date
    on zt_attend (date);

create index reason
    on zt_attend (reason);

create index reviewStatus
    on zt_attend (reviewStatus);

create index reviewedBy
    on zt_attend (reviewedBy);

create index status
    on zt_attend (status);

create table if not exists zt_attendstat
(
    id              int unsigned auto_increment
        primary key,
    account         char(30)                    not null,
    month           char(10)       default ''   not null,
    normal          decimal(12, 2) default 0.00 not null,
    late            decimal(12, 2) default 0.00 not null,
    early           decimal(12, 2) default 0.00 not null,
    absent          decimal(12, 2) default 0.00 not null,
    trip            decimal(12, 2) default 0.00 not null,
    egress          decimal(12, 2) default 0.00 not null,
    lieu            decimal(12, 2) default 0.00 not null,
    paidLeave       decimal(12, 2) default 0.00 not null,
    unpaidLeave     decimal(12, 2) default 0.00 not null,
    timeOvertime    decimal(12, 2) default 0.00 not null,
    restOvertime    decimal(12, 2) default 0.00 not null,
    holidayOvertime decimal(12, 2) default 0.00 not null,
    deserve         decimal(12, 2) default 0.00 not null,
    actual          decimal(12, 2) default 0.00 not null,
    status          char(30)       default ''   not null,
    constraint attend
        unique (month, account)
);

create index account
    on zt_attendstat (account);

create index month
    on zt_attendstat (month);

create index status
    on zt_attendstat (status);

create table if not exists zt_auditcl
(
    id           int unsigned auto_increment
        primary key,
    model        char(30)        default 'waterfall' not null,
    practiceArea char(30)                            not null,
    type         char(30)                            not null,
    title        varchar(255)                        not null,
    objectType   char(30)                            not null,
    objectID     int                                 null,
    assignedTo   varchar(30)                         not null,
    status       varchar(30)                         not null,
    createdBy    varchar(30)                         not null,
    createdDate  datetime                            not null,
    editedBy     varchar(30)                         not null,
    editedDate   datetime                            not null,
    assignedBy   varchar(30)                         not null,
    assignedDate datetime                            not null,
    deleted      enum ('0', '1') default '0'         not null
);

create table if not exists zt_auditplan
(
    id            int unsigned auto_increment
        primary key,
    dateType      char(30)                    null,
    config        text                        null,
    objectID      int                         not null,
    objectType    char(30)                    not null,
    process       int                         not null,
    processType   char(30)                    not null,
    checkDate     date                        not null,
    checkedBy     varchar(30)                 not null,
    realCheckDate date                        not null,
    result        char(30)                    not null,
    project       int unsigned                not null,
    execution     int unsigned                not null,
    assignedTo    varchar(30)                 not null,
    status        varchar(30)                 not null,
    createdBy     varchar(30)                 not null,
    createdDate   datetime                    not null,
    editedBy      varchar(30)                 not null,
    editedDate    datetime                    not null,
    assignedBy    varchar(30)                 not null,
    assignedDate  datetime                    not null,
    deleted       enum ('0', '1') default '0' not null,
    checkBy       varchar(30)                 not null
);

create table if not exists zt_auditresult
(
    id           int unsigned auto_increment
        primary key,
    auditplan    int                         not null,
    listID       int                         not null,
    result       char(30)                    not null,
    checkedBy    varchar(30)                 not null,
    checkedDate  date                        not null,
    comment      text                        not null,
    assignedTo   varchar(30)                 not null,
    status       varchar(30)                 not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    assignedBy   varchar(30)                 not null,
    assignedDate datetime                    not null,
    deleted      enum ('0', '1') default '0' not null
);

create table if not exists zt_baseimage
(
    id            int unsigned auto_increment
        primary key,
    name          varchar(255) default ''  not null,
    path          varchar(255) default ''  not null,
    osType        varchar(50)  default ''  not null,
    os            varchar(50)  default ''  not null,
    osCategory    varchar(50)  default ''  not null,
    osArch        varchar(50)  default ''  not null,
    osLang        varchar(50)  default ''  not null,
    suggestCore   int unsigned default '0' not null,
    suggestMemory int unsigned default '0' not null,
    suggestVolume int unsigned default '0' not null
);

create table if not exists zt_baseimagebrowser
(
    vmBackingID int not null,
    browserID   int not null,
    primary key (vmBackingID, browserID)
);

create table if not exists zt_baseurl
(
    `id`      int auto_increment primary key,
    `product` int  not null,
    `name`    char(50),
    `url`     text not null default ''
);

create table if not exists zt_basicmeas
(
    id          int unsigned auto_increment
        primary key,
    purpose     varchar(50)                 not null,
    scope       char(30)                    not null,
    object      char(30)                    not null,
    name        varchar(90)                 not null,
    code        char(30)                    not null,
    unit        varchar(10)                 not null,
    configure   text                        null,
    params      text                        null,
    definition  text                        null,
    source      varchar(255)                null,
    collectType varchar(30)                 not null,
    collectConf text                        not null,
    execTime    varchar(30)                 not null,
    collectedBy varchar(10)                 not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    `order`     int unsigned    default '0' not null,
    deleted     enum ('0', '1') default '0' not null,
    constraint code
        unique (code)
);

create table if not exists zt_block
(
    id      int unsigned auto_increment
        primary key,
    account char(30)                   not null,
    vision  varchar(10)  default 'rnd' not null,
    module  varchar(20)                not null,
    type    char(30)                   not null,
    title   varchar(100)               not null,
    source  varchar(20)                not null,
    block   varchar(30)                not null,
    params  text                       not null,
    `order` int unsigned default '0'   not null,
    grid    int unsigned default '0'   not null,
    height  int unsigned default '0'   not null,
    hidden  int unsigned default '0'   not null,
    constraint account_vision_module_type_order
        unique (account, vision, module, type, `order`)
);

create index account
    on zt_block (account);

create table if not exists zt_branch
(
    id          int unsigned auto_increment
        primary key,
    product     int unsigned                               not null,
    name        varchar(255)                               not null,
    `default`   enum ('0', '1')           default '0'      not null,
    status      enum ('active', 'closed') default 'active' not null,
    `desc`      varchar(255)                               not null,
    createdDate date                                       not null,
    closedDate  date                                       not null,
    `order`     int unsigned                               not null,
    deleted     enum ('0', '1')           default '0'      not null
);

create index product
    on zt_branch (product);

create table if not exists zt_browser
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255) default '' not null,
    type        varchar(255) default '' not null,
    version     varchar(255) default '' not null,
    lang        varchar(255) default '' not null,
    createdBy   varchar(30)             not null,
    createdDate datetime                not null
);

create table if not exists zt_budget
(
    id             int auto_increment
        primary key,
    project        int unsigned                not null,
    stage          char(30)                    not null,
    subject        int                         not null,
    amount         char(30)                    not null,
    name           varchar(255)                not null,
    `desc`         mediumtext                  not null,
    createdBy      char(30)                    not null,
    createdDate    date                        not null,
    lastEditedBy   char(30)                    not null,
    lastEditedDate date                        not null,
    deleted        enum ('0', '1') default '0' not null
);

create table if not exists zt_bug
(
    id             int auto_increment
        primary key,
    project        int unsigned                                                              not null,
    product        int unsigned                                             default '0'      not null,
    injection      int unsigned                                                              not null,
    identify       int unsigned                                                              not null,
    branch         int unsigned                                             default '0'      not null,
    module         int unsigned                                             default '0'      not null,
    execution      int unsigned                                             default '0'      not null,
    plan           int unsigned                                             default '0'      not null,
    story          int unsigned                                             default '0'      not null,
    storyVersion   int                                                      default 1        not null,
    task           int unsigned                                             default '0'      not null,
    toTask         int unsigned                                             default '0'      not null,
    toStory        int                                                      default 0        not null,
    title          varchar(255)                                                              not null,
    keywords       varchar(255)                                                              not null,
    severity       int                                                      default 0        not null,
    pri            int unsigned                                                              not null,
    type           varchar(30)                                              default ''       not null,
    os             varchar(255)                                             default ''       not null,
    browser        varchar(255)                                             default ''       not null,
    hardware       varchar(30)                                                               not null,
    found          varchar(30)                                              default ''       not null,
    steps          mediumtext                                                                not null,
    status         enum ('active', 'resolved', 'closed', 'tobedeliberated') default 'active' not null,
    subStatus      varchar(30)                                              default ''       not null,
    color          char(7)                                                                   not null,
    confirmed      int                                                      default 0        not null,
    activatedCount int                                                                       not null,
    activatedDate  datetime                                                                  not null,
    feedbackBy     varchar(100)                                                              not null,
    notifyEmail    varchar(100)                                                              not null,
    mailto         text                                                                      null,
    openedBy       varchar(30)                                              default ''       not null,
    openedDate     datetime                                                                  not null,
    openedBuild    varchar(255)                                                              not null,
    assignedTo     varchar(30)                                              default ''       not null,
    assignedDate   datetime                                                                  not null,
    deadline       date                                                                      not null,
    resolvedBy     varchar(30)                                              default ''       not null,
    resolution     varchar(30)                                              default ''       not null,
    resolvedBuild  varchar(30)                                              default ''       not null,
    resolvedDate   datetime                                                                  not null,
    closedBy       varchar(30)                                              default ''       not null,
    closedDate     datetime                                                                  not null,
    duplicateBug   int unsigned                                                              not null,
    linkBug        varchar(255)                                                              not null,
    `case`         int unsigned                                                              not null,
    caseVersion    int                                                      default 1        not null,
    feedback       int unsigned                                             default '0'      not null,
    result         int unsigned                                                              not null,
    repo           int unsigned                                                              not null,
    mr             int unsigned                                                              not null,
    entry          text                                                                      not null,
    `lines`        varchar(10)                                                               not null,
    v1             varchar(40)                                                               not null,
    v2             varchar(40)                                                               not null,
    repoType       varchar(30)                                              default ''       not null,
    issueKey       varchar(50)                                              default ''       not null,
    testtask       int unsigned                                                              not null,
    lastEditedBy   varchar(30)                                              default ''       not null,
    lastEditedDate datetime                                                                  not null,
    deleted        enum ('0', '1')                                          default '0'      not null
);

create index assignedTo
    on zt_bug (assignedTo);

create index `case`
    on zt_bug (`case`);

create index execution
    on zt_bug (execution);

create index plan
    on zt_bug (plan);

create index product
    on zt_bug (product);

create index result
    on zt_bug (result);

create index status
    on zt_bug (status);

create index story
    on zt_bug (story);

create index toStory
    on zt_bug (toStory);

create table if not exists zt_build
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                not null,
    product     int unsigned    default '0' not null,
    branch      int unsigned    default '0' not null,
    execution   int unsigned    default '0' not null,
    name        char(150)                   not null,
    scmPath     char(255)                   not null,
    filePath    char(255)                   not null,
    date        date                        not null,
    stories     text                        not null,
    bugs        text                        not null,
    builder     char(30)        default ''  not null,
    `desc`      mediumtext                  not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create index execution
    on zt_build (execution);

create index product
    on zt_build (product);

create table if not exists zt_burn
(
    execution  int unsigned             not null,
    product    int unsigned             not null,
    task       int unsigned default '0' not null,
    date       date                     not null,
    estimate   float                    not null,
    `left`     float                    not null,
    consumed   float                    not null,
    storyPoint float                    not null,
    primary key (execution, date, task)
);

create table if not exists zt_case
(
    id              int unsigned auto_increment
        primary key,
    project         int unsigned                      not null,
    product         int unsigned         default '0'  not null,
    execution       int unsigned                      not null,
    branch          int unsigned         default '0'  not null,
    lib             int unsigned         default '0'  not null,
    module          int unsigned         default '0'  not null,
    path            int unsigned         default '0'  not null,
    story           int unsigned         default '0'  not null,
    storyVersion    int                  default 1    not null,
    title           varchar(255)                      not null,
    precondition    text                              not null,
    keywords        varchar(255)                      not null,
    pri             int unsigned         default '3'  not null,
    type            char(30)             default '1'  not null,
    auto            varchar(10)          default 'no' not null,
    frame           varchar(10)                       not null,
    stage           varchar(255)                      not null,
    howRun          varchar(30)                       not null,
    scriptedBy      varchar(30)                       not null,
    scriptedDate    date                              not null,
    scriptStatus    varchar(30)                       not null,
    scriptLocation  varchar(255)                      not null,
    status          char(30)             default '1'  not null,
    subStatus       varchar(30)          default ''   not null,
    color           char(7)                           not null,
    frequency       enum ('1', '2', '3') default '1'  not null,
    `order`         int unsigned         default '0'  not null,
    openedBy        char(30)             default ''   not null,
    openedDate      datetime                          not null,
    reviewedBy      varchar(255)                      not null,
    reviewedDate    date                              not null,
    lastEditedBy    char(30)             default ''   not null,
    lastEditedDate  datetime                          not null,
    version         int unsigned         default '0'  not null,
    linkCase        varchar(255)                      not null,
    fromBug         int unsigned                      not null,
    fromCaseID      int unsigned                      not null,
    fromCaseVersion int unsigned         default '1'  not null,
    deleted         enum ('0', '1')      default '0'  not null,
    lastRunner      varchar(30)                       not null,
    lastRunDate     datetime                          not null,
    lastRunResult   char(30)                          not null
);

create index fromBug
    on zt_case (fromBug);

create index module
    on zt_case (module);

create index product
    on zt_case (product);

create index story
    on zt_case (story);

create table if not exists zt_casestep
(
    id            int unsigned auto_increment
        primary key,
    parent        int unsigned default '0'    not null,
    `case`        int unsigned default '0'    not null,
    version       int unsigned default '0'    not null,
    type          varchar(10)  default 'step' not null,
    `desc`        text                        not null,
    goal_action   text                        not null,
    expect        text                        not null,
    eval_criteria text                        not null
);

create index `case`
    on zt_casestep (`case`);

create index version
    on zt_casestep (version);

create table if not exists zt_cfd
(
    id        int auto_increment
        primary key,
    execution int      not null,
    type      char(30) not null,
    name      char(30) not null,
    count     int      not null,
    date      date     not null,
    constraint execution_type_name_date
        unique (execution, type, name, date)
);

create table if not exists zt_chart
(
    id          int auto_increment
        primary key,
    name        varchar(255)  not null,
    type        varchar(30)   not null,
    dataset     varchar(30)   not null,
    `desc`      mediumtext    not null,
    settings    mediumtext    not null,
    filters     mediumtext    not null,
    createdBy   char(30)      not null,
    createdDate datetime      not null,
    deleted     int default 0 not null
);

create table if not exists zt_cmcl
(
    id          int unsigned auto_increment
        primary key,
    type        char(30)                    not null,
    title       int                         not null,
    contents    text                        not null,
    assignedTo  varchar(30)                 not null,
    status      varchar(30)                 not null,
    `order`     int                         not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_company
(
    id       int unsigned auto_increment
        primary key,
    name     char(120)                   null,
    phone    char(20)                    null,
    fax      char(20)                    null,
    address  char(120)                   null,
    zipcode  char(10)                    null,
    website  char(120)                   null,
    backyard char(120)                   null,
    guest    enum ('1', '0') default '0' not null,
    admins   char(255)                   null,
    deleted  enum ('0', '1') default '0' not null
);

create table if not exists zt_compile
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(50)                 not null,
    job         int unsigned                not null,
    queue       int                         not null,
    status      varchar(255)                not null,
    logs        text                        null,
    atTime      varchar(10)                 not null,
    testtask    int unsigned                not null,
    tag         varchar(255)                not null,
    times       int unsigned    default '0' not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    updateDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_config
(
    id      int unsigned auto_increment
        primary key,
    vision  varchar(10) default '' not null,
    owner   char(30)    default '' not null,
    module  varchar(30)            not null,
    section char(30)    default '' not null,
    `key`   char(30)    default '' not null,
    value   longtext               not null,
    constraint `unique`
        unique (vision, owner, module, section, `key`)
);

create table if not exists zt_cron
(
    id       int unsigned auto_increment
        primary key,
    m        varchar(20)   not null,
    h        varchar(20)   not null,
    dom      varchar(20)   not null,
    mon      varchar(20)   not null,
    dow      varchar(20)   not null,
    command  text          not null,
    remark   varchar(255)  not null,
    type     varchar(20)   not null,
    buildin  int default 0 not null,
    status   varchar(20)   not null,
    lastTime datetime      not null
);

create index lastTime
    on zt_cron (lastTime);

create table if not exists zt_dashboard
(
    id          int auto_increment
        primary key,
    name        varchar(255)  not null,
    module      int           not null,
    `desc`      mediumtext    not null,
    layout      mediumtext    not null,
    filters     mediumtext    not null,
    createdBy   varchar(30)   not null,
    createdDate datetime      not null,
    deleted     int default 0 not null
);

create table if not exists zt_dataset
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(155)  not null,
    `sql`       text          not null,
    fields      mediumtext    not null,
    objects     mediumtext    not null,
    createdBy   varchar(30)   not null,
    createdDate datetime      not null,
    deleted     int default 0 not null
);

create table if not exists zt_data_sample
(
    id             int unsigned auto_increment comment '数据样本的ID'
        primary key,
    case_id        int unsigned not null comment '用例外键ID',
    casestep_id    int unsigned not null comment '测试步骤外键ID',
    casestep_level int unsigned not null comment '测试步骤编号',
    rules          text         not null comment '样本规则',
    object         text         not null comment '样本实体',
    version        int unsigned not null comment '数据样本版本 对应于测试用例和步骤的版本'
)
    engine = InnoDB;

create table if not exists zt_data_sample_result
(
    id             int unsigned auto_increment comment '数据样本结果的ID'
        primary key,
    data_sample_id int unsigned not null comment '数据样本外键ID',
    object         text         not null comment '样本结果实体',
    create_date    datetime     not null default CURRENT_TIMESTAMP comment '创建时间与日期',
    version        int unsigned not null comment '数据样本结果版本 对应于测试用例和步骤的版本'
)
    engine = InnoDB;

create table if not exists zt_deliberation
(
    id              int auto_increment
        primary key,
    frombugid       int                                        not null,
    deliberateddate datetime                                   not null,
    description     text                                       null,
    tostatus        enum ('active', 'closed') default 'active' not null,
    launcherid      int                                        not null,
    organizerid     int                                        not null,
    times           int                                        not null,
    deleted         enum ('0', '1')           default '0'      not null
)
    engine = InnoDB;

create index frombugid
    on zt_deliberation (frombugid);

create table if not exists zt_deploy
(
    id          int unsigned auto_increment
        primary key,
    begin       datetime        not null,
    end         datetime        not null,
    name        varchar(255)    not null,
    `desc`      mediumtext      not null,
    status      varchar(20)     not null,
    owner       char(30)        not null,
    members     text            not null,
    notify      text            not null,
    cases       text            not null,
    createdBy   char(30)        not null,
    createdDate datetime        not null,
    result      varchar(20)     not null,
    deleted     enum ('0', '1') not null
);

create table if not exists zt_deployproduct
(
    deploy    int unsigned not null,
    product   int unsigned not null,
    `release` int unsigned not null,
    package   varchar(255) not null,
    constraint deploy_product_release
        unique (deploy, product, `release`)
);

create table if not exists zt_deployscope
(
    deploy  int unsigned not null,
    service int unsigned not null,
    hosts   text         not null,
    remove  text         not null,
    `add`   text         not null
);

create table if not exists zt_deploystep
(
    id           int unsigned auto_increment
        primary key,
    deploy       int unsigned    not null,
    title        varchar(255)    not null,
    begin        datetime        not null,
    end          datetime        not null,
    stage        varchar(30)     not null,
    content      text            not null,
    status       varchar(30)     not null,
    assignedTo   char(30)        not null,
    assignedDate datetime        not null,
    finishedBy   char(30)        not null,
    finishedDate datetime        not null,
    createdBy    char(30)        not null,
    createdDate  datetime        not null,
    deleted      enum ('0', '1') not null
);

create table if not exists zt_dept
(
    id         int unsigned auto_increment
        primary key,
    name       char(60)                 not null,
    parent     int unsigned default '0' not null,
    path       char(255)    default ''  not null,
    grade      int unsigned default '0' not null,
    `order`    int unsigned default '0' not null,
    position   char(30)     default ''  not null,
    `function` char(255)    default ''  not null,
    manager    char(30)     default ''  not null
);

create index parent
    on zt_dept (parent);

create index path
    on zt_dept (path);

create table if not exists zt_design
(
    id           int unsigned auto_increment
        primary key,
    project      varchar(255)                not null,
    product      varchar(255)                not null,
    commit       text                        not null,
    commitedBy   varchar(30)                 not null,
    execution    int unsigned    default '0' not null,
    name         varchar(255)                not null,
    status       varchar(30)                 not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    assignedTo   varchar(30)                 not null,
    assignedBy   varchar(30)                 not null,
    assignedDate datetime                    not null,
    deleted      enum ('0', '1') default '0' not null,
    story        char(30)                    not null,
    `desc`       mediumtext                  not null,
    version      int                         not null,
    type         char(30)                    not null
);

create table if not exists zt_designspec
(
    design  int          not null,
    version int          not null,
    name    varchar(255) not null,
    `desc`  mediumtext   not null,
    files   varchar(255) not null,
    constraint design
        unique (design, version)
);

create table if not exists zt_doc
(
    id           int unsigned auto_increment
        primary key,
    vision       varchar(10)     default 'rnd'  not null,
    project      int unsigned                   not null,
    product      int unsigned                   not null,
    execution    int unsigned                   not null,
    lib          varchar(30)                    not null,
    template     varchar(30)                    not null,
    templateType varchar(30)                    not null,
    chapterType  varchar(30)                    not null,
    module       varchar(30)                    not null,
    title        varchar(255)                   not null,
    keywords     varchar(255)                   not null,
    type         varchar(30)                    not null,
    status       varchar(30)                    not null,
    parent       int unsigned    default '0'    not null,
    path         char(255)       default ''     not null,
    grade        int unsigned    default '0'    not null,
    `order`      int unsigned    default '0'    not null,
    views        int unsigned                   not null,
    assetLib     int unsigned    default '0'    not null,
    assetLibType varchar(30)     default ''     not null,
    `from`       int unsigned    default '0'    not null,
    fromVersion  int             default 1      not null,
    draft        longtext                       not null,
    collector    text                           not null,
    addedBy      varchar(30)                    not null,
    addedDate    datetime                       not null,
    assignedTo   varchar(30)                    not null,
    assignedDate datetime                       not null,
    approvedDate date                           not null,
    editedBy     varchar(30)                    not null,
    editedDate   datetime                       not null,
    mailto       text                           null,
    acl          varchar(10)     default 'open' not null,
    `groups`     varchar(255)                   not null,
    users        text                           not null,
    version      int unsigned    default '1'    not null,
    deleted      enum ('0', '1') default '0'    not null
);

create index execution
    on zt_doc (execution);

create index lib
    on zt_doc (lib);

create index product
    on zt_doc (product);

create table if not exists zt_doccontent
(
    id      int unsigned auto_increment
        primary key,
    doc     int unsigned not null,
    title   varchar(255) not null,
    digest  varchar(255) not null,
    content longtext     not null,
    files   text         not null,
    type    varchar(10)  not null,
    version int unsigned not null,
    constraint doc_version
        unique (doc, version)
);

create table if not exists zt_doclib
(
    id        int unsigned auto_increment
        primary key,
    type      varchar(30)                    not null,
    vision    varchar(10)     default 'rnd'  not null,
    product   int unsigned                   not null,
    project   int unsigned                   not null,
    execution int unsigned                   not null,
    name      varchar(60)                    not null,
    baseUrl   varchar(255)    default ''     not null,
    acl       varchar(10)     default 'open' not null,
    `groups`  varchar(255)                   not null,
    users     text                           not null,
    main      enum ('0', '1') default '0'    not null,
    collector text                           not null,
    `desc`    mediumtext                     not null,
    `order`   int unsigned                   not null,
    deleted   enum ('0', '1') default '0'    not null
);

create index execution
    on zt_doclib (execution);

create index product
    on zt_doclib (product);

create table if not exists zt_domain
(
    id          int unsigned auto_increment
        primary key,
    domain      varchar(255)                not null,
    adminURI    varchar(255)                not null,
    resolverURI varchar(255)                not null,
    register    varchar(255)                not null,
    expiredDate datetime                    not null,
    renew       varchar(255)                not null,
    account     varchar(255)                not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create index domain
    on zt_domain (domain);

create table if not exists zt_durationestimation
(
    id           int unsigned auto_increment
        primary key,
    project      int unsigned                not null,
    stage        int                         not null,
    workload     varchar(255)                not null,
    worktimeRate varchar(255)                not null,
    people       varchar(255)                not null,
    startDate    date                        not null,
    endDate      date                        not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    deleted      enum ('0', '1') default '0' not null
);

create table if not exists zt_effort
(
    id         int unsigned auto_increment
        primary key,
    objectType varchar(30)                   not null,
    objectID   int unsigned                  not null,
    product    text                          not null,
    project    int unsigned                  not null,
    execution  int unsigned                  not null,
    account    varchar(30)                   not null,
    work       text                          null,
    syncStatus enum ('0', '1') default '0'   not null,
    vision     varchar(10)     default 'rnd' not null,
    date       date                          not null,
    `left`     float                         not null,
    consumed   float                         not null,
    begin      int unsigned zerofill         not null,
    end        int unsigned zerofill         not null,
    `order`    int unsigned    default '0'   not null,
    deleted    enum ('0', '1') default '0'   not null
);

create index account
    on zt_effort (account);

create index date
    on zt_effort (date);

create index execution
    on zt_effort (execution);

create index objectID
    on zt_effort (objectID);

create table if not exists zt_entry
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(50)                 not null,
    account     varchar(30)     default ''  not null,
    code        varchar(20)                 not null,
    `key`       varchar(32)                 not null,
    freePasswd  enum ('0', '1') default '0' not null,
    ip          varchar(100)                not null,
    `desc`      mediumtext                  not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    calledTime  int unsigned    default '0' not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_expect
(
    id          int auto_increment
        primary key,
    userID      int                         not null,
    project     int             default 0   not null,
    expect      text                        not null,
    progress    text                        not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_extension
(
    id               int unsigned auto_increment
        primary key,
    name             varchar(150)                    not null,
    code             varchar(30)                     not null,
    version          varchar(50)                     not null,
    author           varchar(100)                    not null,
    `desc`           mediumtext                      not null,
    license          text                            not null,
    type             varchar(20) default 'extension' not null,
    site             varchar(150)                    not null,
    zentaoCompatible varchar(100)                    not null,
    installedTime    datetime                        not null,
    depends          varchar(100)                    not null,
    dirs             mediumtext                      not null,
    files            mediumtext                      not null,
    status           varchar(20)                     not null,
    constraint code
        unique (code)
);

create index installedTime
    on zt_extension (installedTime);

create index name
    on zt_extension (name);

create table if not exists zt_faq
(
    id        int auto_increment
        primary key,
    module    int          not null,
    product   int          not null,
    question  varchar(255) not null,
    answer    text         not null,
    addedtime datetime     not null
);

create table if not exists zt_feedback
(
    id             int unsigned auto_increment
        primary key,
    product        int unsigned                not null,
    module         int unsigned                not null,
    title          varchar(255)                not null,
    type           char(30)                    not null,
    solution       char(30)                    not null,
    `desc`         text                        not null,
    pri            int unsigned    default '2' not null,
    status         varchar(30)                 not null,
    subStatus      varchar(30)     default ''  not null,
    public         enum ('0', '1') default '0' not null,
    notify         enum ('0', '1') default '0' not null,
    notifyEmail    varchar(100)                not null,
    source         varchar(255)                not null,
    likes          text                        not null,
    result         int unsigned                not null,
    faq            int unsigned                not null,
    openedBy       char(30)                    not null,
    openedDate     datetime                    not null,
    reviewedBy     varchar(255)                not null,
    reviewedDate   datetime                    not null,
    processedBy    char(30)                    not null,
    processedDate  datetime                    not null,
    closedBy       char(30)                    not null,
    closedDate     datetime                    not null,
    closedReason   varchar(30)                 not null,
    editedBy       char(30)                    not null,
    editedDate     datetime                    not null,
    assignedTo     varchar(255)                not null,
    assignedDate   datetime                    not null,
    feedbackBy     varchar(100)                not null,
    repeatFeedback int             default 0   not null,
    mailto         varchar(255)                not null,
    deleted        enum ('0', '1') default '0' not null,
    updateDate     datetime                    not null,
    exportDate     datetime                    not null,
    createdAt      varchar(50)     default ''  not null,
    feedbackExId   varchar(36)     default ''  not null,
    contactWay     varchar(255)    default ''  not null,
    expectDate     datetime                    not null,
    usedProject    varchar(255)    default ''  not null,
    productVersion varchar(255)    default ''  not null
);

create table if not exists zt_feedbackview
(
    account char(30)     not null,
    product int unsigned not null,
    constraint account_product
        unique (account, product)
);

create table if not exists zt_file
(
    id         int unsigned auto_increment
        primary key,
    pathname   char(100)                   not null,
    title      varchar(255)                not null,
    extension  char(30)                    not null,
    size       int unsigned    default '0' not null,
    objectType char(30)                    not null,
    objectID   int                         not null,
    addedBy    char(30)        default ''  not null,
    addedDate  datetime                    not null,
    downloads  int unsigned    default '0' not null,
    extra      varchar(255)                not null,
    deleted    enum ('0', '1') default '0' not null,
    enternalId varchar(36)     default ''  not null
);

create index objectID
    on zt_file (objectID);

create index objectType
    on zt_file (objectType);

create table if not exists zt_gapanalysis
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                    not null,
    account     varchar(30)                     not null,
    role        varchar(20)                     not null,
    analysis    mediumtext                      not null,
    needTrain   enum ('no', 'yes') default 'no' not null,
    createdBy   char(30)                        null,
    createdDate datetime                        not null,
    editedBy    varchar(30)                     not null,
    editedDate  datetime                        not null,
    deleted     enum ('0', '1')    default '0'  not null,
    constraint project_account
        unique (project, account)
);

create table if not exists zt_group
(
    id        int unsigned auto_increment
        primary key,
    project   int unsigned    default '0'   not null,
    vision    varchar(10)     default 'rnd' not null,
    name      char(30)                      not null,
    role      char(30)        default ''    not null,
    `desc`    char(255)       default ''    not null,
    acl       text                          null,
    developer enum ('0', '1') default '1'   not null
);

create table if not exists zt_grouppriv
(
    `group` int unsigned default '0' not null,
    module  char(30)     default ''  not null,
    method  char(30)     default ''  not null,
    constraint `group`
        unique (`group`, module, method)
);

create table if not exists zt_history
(
    id     int unsigned auto_increment
        primary key,
    action int unsigned default '0' not null,
    field  varchar(30)  default ''  not null,
    old    text                     not null,
    new    text                     not null,
    diff   mediumtext               not null
);

create index action
    on zt_history (action);

create table if not exists zt_holiday
(
    id     int unsigned auto_increment
        primary key,
    name   varchar(30)                 default ''        not null,
    type   enum ('holiday', 'working') default 'holiday' not null,
    `desc` mediumtext                                    not null,
    year   char(4)                                       not null,
    begin  date                                          not null,
    end    date                                          not null
);

create index name
    on zt_holiday (name);

create index year
    on zt_holiday (year);

create table if not exists zt_host
(
    id             int unsigned auto_increment
        primary key,
    assetID        int unsigned                   not null,
    admin          int unsigned      default '0'  not null,
    serverRoom     int unsigned                   not null,
    cabinet        varchar(128)                   not null,
    serverModel    varchar(256)                   not null,
    hardwareType   varchar(64)                    not null,
    hostType       enum ('physical', 'virtual')   not null,
    cpuBrand       varchar(128)                   not null,
    cpuModel       varchar(128)                   not null,
    cpuNumber      varchar(16)                    not null,
    cpuCores       varchar(30)                    not null,
    cpuRate        varchar(30)                    not null,
    memory         varchar(30)                    not null,
    diskType       varchar(30)                    not null,
    diskSize       varchar(30)                    not null,
    unit           enum ('GB', 'TB') default 'GB' not null,
    privateIP      varchar(128)                   not null,
    publicIP       varchar(128)                   not null,
    nic            varchar(128)                   not null,
    mac            varchar(128)                   not null,
    osName         varchar(64)                    not null,
    osVersion      varchar(64)                    not null,
    webserver      varchar(128)                   not null,
    `database`     varchar(128)                   not null,
    language       varchar(16)                    not null,
    status         varchar(50)                    not null,
    agentPort      varchar(10)                    not null,
    instanceNum    int               default 0    not null,
    pri            int unsigned      default '0'  not null,
    heartbeatTime  datetime                       not null,
    tags           varchar(50)       default ''   not null,
    provider       varchar(255)      default ''   not null,
    bridgeID       varchar(255)      default ''   not null,
    cloudKey       varchar(255)      default ''   not null,
    cloudSecret    varchar(255)      default ''   not null,
    cloudRegion    varchar(255)      default ''   not null,
    cloudNamespace varchar(255)      default ''   not null,
    cloudUser      varchar(255)      default ''   not null,
    cloudAccount   varchar(255)      default ''   not null,
    cloudPassword  varchar(255)      default ''   not null,
    couldVPC       varchar(255)      default ''   not null
);

create table if not exists zt_im_chat
(
    id               int unsigned auto_increment
        primary key,
    gid              char(40)        default ''                    not null,
    name             varchar(60)     default ''                    not null,
    type             varchar(20)     default 'group'               not null,
    admins           varchar(255)    default ''                    not null,
    committers       varchar(255)    default ''                    not null,
    subject          int unsigned    default '0'                   not null,
    public           enum ('0', '1') default '0'                   not null,
    createdBy        varchar(30)     default ''                    not null,
    createdDate      datetime        default '0000-00-00 00:00:00' not null,
    ownedBy          varchar(30)     default ''                    not null,
    editedBy         varchar(30)     default ''                    not null,
    editedDate       datetime        default '0000-00-00 00:00:00' not null,
    mergedDate       datetime        default '0000-00-00 00:00:00' not null,
    lastActiveTime   datetime        default '0000-00-00 00:00:00' not null,
    lastMessage      int unsigned    default '0'                   not null,
    lastMessageIndex int unsigned    default '0'                   not null,
    dismissDate      datetime        default '0000-00-00 00:00:00' not null,
    pinnedMessages   text                                          not null,
    mergedChats      text                                          not null,
    adminInvite      enum ('0', '1') default '0'                   not null,
    avatar           text                                          not null
);

create index createdBy
    on zt_im_chat (createdBy);

create index editedBy
    on zt_im_chat (editedBy);

create index gid
    on zt_im_chat (gid);

create index name
    on zt_im_chat (name);

create index public
    on zt_im_chat (public);

create index type
    on zt_im_chat (type);

create table if not exists zt_im_chatuser
(
    id                   int unsigned auto_increment
        primary key,
    cgid                 char(40)        default ''                    not null,
    user                 int             default 0                     not null,
    `order`              int             default 0                     not null,
    star                 enum ('0', '1') default '0'                   not null,
    hide                 enum ('0', '1') default '0'                   not null,
    mute                 enum ('0', '1') default '0'                   not null,
    freeze               enum ('0', '1') default '0'                   not null,
    `join`               datetime        default '0000-00-00 00:00:00' not null,
    quit                 datetime        default '0000-00-00 00:00:00' not null,
    category             varchar(40)     default ''                    not null,
    lastReadMessage      int unsigned    default '0'                   not null,
    lastReadMessageIndex int unsigned    default '0'                   not null,
    constraint chatuser
        unique (cgid, user)
);

create index cgid
    on zt_im_chatuser (cgid);

create index hide
    on zt_im_chatuser (hide);

create index `order`
    on zt_im_chatuser (`order`);

create index star
    on zt_im_chatuser (star);

create index user
    on zt_im_chatuser (user);

create table if not exists zt_im_chat_message_index
(
    id         int unsigned auto_increment
        primary key,
    gid        char(40)                               not null,
    tableName  char(64)                               not null,
    start      int unsigned                           not null,
    end        int unsigned                           not null,
    startIndex int unsigned                           not null,
    endIndex   int unsigned                           not null,
    startDate  datetime default '0000-00-00 00:00:00' not null,
    endDate    datetime default '0000-00-00 00:00:00' not null,
    count      int unsigned                           not null,
    constraint chattable
        unique (gid, tableName)
);

create index chatendindex
    on zt_im_chat_message_index (gid, endIndex);

create index chatstartindex
    on zt_im_chat_message_index (gid, startIndex);

create index end
    on zt_im_chat_message_index (end);

create index endDate
    on zt_im_chat_message_index (endDate);

create index start
    on zt_im_chat_message_index (start);

create index startDate
    on zt_im_chat_message_index (startDate);

create table if not exists zt_im_client
(
    id          int unsigned auto_increment
        primary key,
    version     char(30)                  default ''     not null,
    `desc`      varchar(100)              default ''     not null,
    changeLog   text                                     not null,
    strategy    varchar(10)               default ''     not null,
    downloads   text                                     not null,
    createdDate datetime                                 not null,
    createdBy   varchar(30)               default ''     not null,
    editedDate  datetime                                 not null,
    editedBy    varchar(30)               default ''     not null,
    status      enum ('released', 'wait') default 'wait' not null
);

create table if not exists zt_im_conference
(
    id           int unsigned auto_increment
        primary key,
    rid          char(40)                default ''                    not null,
    cgid         char(40)                default ''                    not null,
    status       enum ('closed', 'open') default 'closed'              not null,
    participants text                                                  not null,
    invitee      text                                                  not null,
    openedBy     int                     default 0                     not null,
    openedDate   datetime                default '0000-00-00 00:00:00' not null
);

create table if not exists zt_im_conferenceaction
(
    id     int unsigned auto_increment
        primary key,
    rid    char(40)                                                       default ''                    not null,
    type   enum ('create', 'invite', 'join', 'leave', 'close', 'publish') default 'create'              not null,
    data   text                                                                                         not null,
    user   int                                                            default 0                     not null,
    date   datetime                                                       default '0000-00-00 00:00:00' not null,
    device char(40)                                                       default 'default'             not null
);

create table if not exists zt_im_message
(
    id          int unsigned auto_increment
        primary key,
    gid         char(40)                                                             default ''                    not null,
    cgid        char(40)                                                             default ''                    not null,
    user        varchar(30)                                                          default ''                    not null,
    date        datetime                                                             default '0000-00-00 00:00:00' not null,
    `index`     int unsigned                                                         default '0'                   not null,
    type        enum ('normal', 'broadcast', 'notify', 'bulletin')                   default 'normal'              not null,
    content     text                                                                                               not null,
    contentType enum ('text', 'plain', 'emotion', 'image', 'file', 'object', 'code') default 'text'                not null,
    data        text                                                                                               not null,
    deleted     enum ('0', '1')                                                      default '0'                   not null
);

create index mcgid
    on zt_im_message (cgid);

create index mgid
    on zt_im_message (gid);

create index mtype
    on zt_im_message (type);

create index muser
    on zt_im_message (user);

create table if not exists zt_im_messagestatus
(
    user    int                                           default 0         not null,
    message int unsigned                                                    not null,
    status  enum ('waiting', 'sent', 'readed', 'deleted') default 'waiting' not null,
    constraint user
        unique (user, message)
);

create table if not exists zt_im_message_backup
(
    id          int unsigned                                                                                       not null,
    gid         char(40)                                                             default ''                    not null,
    cgid        char(40)                                                             default ''                    not null,
    user        varchar(30)                                                          default ''                    not null,
    date        datetime                                                             default '0000-00-00 00:00:00' not null,
    `index`     int unsigned                                                         default '0'                   not null,
    type        enum ('normal', 'broadcast', 'notify')                               default 'normal'              not null,
    content     text                                                                                               not null,
    contentType enum ('text', 'plain', 'emotion', 'image', 'file', 'object', 'code') default 'text'                not null,
    data        text                                                                                               not null,
    deleted     enum ('0', '1')                                                      default '0'                   not null
);

create table if not exists zt_im_message_index
(
    id        int unsigned auto_increment
        primary key,
    tableName char(64)                               not null,
    start     int unsigned                           not null,
    end       int unsigned                           not null,
    startDate datetime default '0000-00-00 00:00:00' not null,
    endDate   datetime default '0000-00-00 00:00:00' not null,
    chats     text                                   not null
);

create index end
    on zt_im_message_index (end);

create index endDate
    on zt_im_message_index (endDate);

create index start
    on zt_im_message_index (start);

create index startDate
    on zt_im_message_index (startDate);

create index tableName
    on zt_im_message_index (tableName);

create table if not exists zt_im_queue
(
    id          int unsigned auto_increment
        primary key,
    type        char(30) not null,
    content     text     not null,
    addDate     datetime not null,
    processDate datetime not null,
    result      text     not null,
    status      char(30) not null
);

create table if not exists zt_im_userdevice
(
    id         int unsigned auto_increment
        primary key,
    user       int      default 0                     not null,
    device     char(40) default 'default'             not null,
    deviceID   char(40) default ''                    not null,
    token      char(64) default ''                    not null,
    validUntil datetime default '0000-00-00 00:00:00' not null,
    lastLogin  datetime default '0000-00-00 00:00:00' not null,
    lastLogout datetime default '0000-00-00 00:00:00' not null,
    constraint userdevice
        unique (user, device)
);

create index lastLogin
    on zt_im_userdevice (lastLogin);

create index lastLogout
    on zt_im_userdevice (lastLogout);

create index user
    on zt_im_userdevice (user);

create table if not exists zt_interface
(
    id      int auto_increment
        primary key,
    product int                                                                          not null,
    name    char(50)                                                                     null,
    method  enum ('GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT') not null,
    url     text                                                                         not null,
    module  int             default 0                                                    not null,
    header  json                                                                         null,
    data    json                                                                         null,
    format  char(50)        default 'json'                                               not null,
    deleted enum ('0', '1') default '0'                                                  not null
);

create table if not exists zt_intervention
(
    id          int auto_increment
        primary key,
    project     int unsigned    not null,
    activity    int             not null,
    status      char(30)        not null,
    partake     text            not null,
    begin       date            not null,
    realBegin   date            not null,
    situation   varchar(255)    not null,
    createdBy   char(30)        not null,
    createdDate date            not null,
    deleted     enum ('0', '1') not null,
    constraint project
        unique (project, activity)
);

create table if not exists zt_issue
(
    id                int unsigned auto_increment
        primary key,
    resolvedBy        varchar(30)                 not null,
    project           varchar(255)                not null,
    execution         int unsigned                not null,
    title             varchar(255)                not null,
    `desc`            mediumtext                  not null,
    pri               char(30)                    not null,
    severity          char(30)                    not null,
    type              char(30)                    not null,
    activity          varchar(255)                not null,
    deadline          date                        not null,
    resolution        char(30)                    not null,
    resolutionComment text                        not null,
    objectID          varchar(255)                not null,
    resolvedDate      date                        not null,
    status            varchar(30)                 not null,
    owner             varchar(255)                not null,
    lib               int unsigned    default '0' not null,
    `from`            int unsigned    default '0' not null,
    version           int             default 1   not null,
    createdBy         varchar(30)                 not null,
    createdDate       datetime                    not null,
    editedBy          varchar(30)                 not null,
    editedDate        datetime                    not null,
    activateBy        varchar(30)                 not null,
    activateDate      date                        not null,
    closedBy          varchar(30)                 not null,
    closedDate        date                        not null,
    assignedTo        varchar(30)                 not null,
    assignedBy        varchar(30)                 not null,
    assignedDate      datetime                    not null,
    approvedDate      date                        not null,
    deleted           enum ('0', '1') default '0' not null
);

create table if not exists zt_job
(
    id              int unsigned auto_increment
        primary key,
    name            varchar(50)                 not null,
    repo            int unsigned                not null,
    product         int unsigned                not null,
    frame           varchar(20)                 not null,
    engine          varchar(20)                 not null,
    server          int unsigned                not null,
    pipeline        varchar(500)                not null,
    triggerType     varchar(255)                not null,
    sonarqubeServer int unsigned                not null,
    projectKey      varchar(255)                not null,
    svnDir          varchar(255)                not null,
    atDay           varchar(255)                null,
    atTime          varchar(10)                 null,
    customParam     text                        not null,
    comment         varchar(255)                null,
    createdBy       varchar(30)                 not null,
    createdDate     datetime                    not null,
    editedBy        varchar(30)                 not null,
    editedDate      datetime                    not null,
    lastExec        datetime                    null,
    lastStatus      varchar(255)                null,
    lastTag         varchar(255)                null,
    lastSyncDate    datetime                    null,
    deleted         enum ('0', '1') default '0' not null
);

create table if not exists zt_kanban
(
    id             int unsigned auto_increment
        primary key,
    space          int unsigned                               not null,
    name           varchar(255)                               not null,
    owner          varchar(30)                                not null,
    team           text                                       not null,
    `desc`         mediumtext                                 not null,
    acl            char(30)                  default 'open'   not null,
    whitelist      text                                       not null,
    archived       enum ('0', '1')           default '1'      not null,
    performable    enum ('0', '1')           default '0'      not null,
    status         enum ('active', 'closed') default 'active' not null,
    `order`        int                       default 0        not null,
    displayCards   int                       default 0        not null,
    showWIP        enum ('0', '1')           default '1'      not null,
    fluidBoard     enum ('0', '1')           default '0'      not null,
    colWidth       int                       default 264      not null,
    minColWidth    int                       default 180      not null,
    maxColWidth    int                       default 384      not null,
    object         varchar(255)                               not null,
    alignment      varchar(10)               default 'center' not null,
    createdBy      char(30)                                   not null,
    createdDate    datetime                                   not null,
    lastEditedBy   char(30)                                   not null,
    lastEditedDate datetime                                   not null,
    closedBy       char(30)                                   not null,
    closedDate     datetime                                   not null,
    activatedBy    char(30)                                   not null,
    activatedDate  datetime                                   not null,
    deleted        enum ('0', '1')           default '0'      not null
);

create table if not exists zt_kanbancard
(
    id             int unsigned auto_increment
        primary key,
    kanban         int unsigned                    not null,
    region         int unsigned                    not null,
    `group`        int unsigned                    not null,
    fromID         int unsigned                    not null,
    fromType       varchar(30)                     not null,
    name           varchar(255)                    not null,
    status         varchar(30)     default 'doing' not null,
    pri            int unsigned                    not null,
    assignedTo     text                            not null,
    `desc`         mediumtext                      not null,
    begin          date                            not null,
    end            date                            not null,
    estimate       float unsigned                  not null,
    progress       float unsigned  default '0'     not null,
    color          char(7)                         not null,
    acl            char(30)        default 'open'  not null,
    whitelist      text                            not null,
    `order`        int             default 0       not null,
    archived       enum ('0', '1') default '0'     not null,
    createdBy      char(30)                        not null,
    createdDate    datetime                        not null,
    lastEditedBy   char(30)                        not null,
    lastEditedDate datetime                        not null,
    archivedBy     char(30)                        not null,
    archivedDate   datetime                        not null,
    assignedBy     char(30)                        not null,
    assignedDate   datetime                        not null,
    deleted        enum ('0', '1') default '0'     not null
);

create table if not exists zt_kanbancell
(
    id       int auto_increment
        primary key,
    kanban   int      not null,
    lane     int      not null,
    `column` int      not null,
    type     char(30) not null,
    cards    text     not null,
    constraint card_group
        unique (kanban, type, lane, `column`)
);

create table if not exists zt_kanbancolumn
(
    id       int auto_increment
        primary key,
    parent   int             default 0   not null,
    type     char(30)                    not null,
    region   int unsigned                not null,
    `group`  int             default 0   not null,
    name     varchar(255)    default ''  not null,
    color    char(30)                    not null,
    `limit`  int             default -1  not null,
    `order`  int             default 0   not null,
    archived enum ('0', '1') default '0' not null,
    deleted  enum ('0', '1') default '0' not null
);

create table if not exists zt_kanbangroup
(
    id      int unsigned auto_increment
        primary key,
    kanban  int unsigned  not null,
    region  int unsigned  not null,
    `order` int default 0 not null
);

create table if not exists zt_kanbanlane
(
    id             int auto_increment
        primary key,
    execution      int             default 0   not null,
    type           char(30)                    not null,
    region         int unsigned                not null,
    `group`        int unsigned                not null,
    groupby        char(30)                    not null,
    extra          char(30)                    not null,
    name           varchar(255)    default ''  not null,
    color          char(30)                    not null,
    `order`        int             default 0   not null,
    lastEditedTime datetime                    not null,
    deleted        enum ('0', '1') default '0' not null
);

create table if not exists zt_kanbanregion
(
    id             int unsigned auto_increment
        primary key,
    space          int unsigned                not null,
    kanban         int unsigned                not null,
    name           varchar(255)                not null,
    `order`        int             default 0   not null,
    createdBy      char(30)                    not null,
    createdDate    datetime                    not null,
    lastEditedBy   char(30)                    not null,
    lastEditedDate datetime                    not null,
    deleted        enum ('0', '1') default '0' not null
);

create table if not exists zt_kanbanspace
(
    id             int unsigned auto_increment
        primary key,
    name           varchar(255)                               not null,
    type           varchar(50)                                not null,
    owner          varchar(30)                                not null,
    team           text                                       not null,
    `desc`         mediumtext                                 not null,
    acl            char(30)                  default 'open'   not null,
    whitelist      text                                       not null,
    status         enum ('active', 'closed') default 'active' not null,
    `order`        int                       default 0        not null,
    createdBy      char(30)                                   not null,
    createdDate    datetime                                   not null,
    lastEditedBy   char(30)                                   not null,
    lastEditedDate datetime                                   not null,
    closedBy       char(30)                                   not null,
    closedDate     datetime                                   not null,
    activatedBy    char(30)                                   not null,
    activatedDate  datetime                                   not null,
    deleted        enum ('0', '1')           default '0'      not null
);

create table if not exists zt_lang
(
    id       int unsigned auto_increment
        primary key,
    lang     varchar(30)                   not null,
    module   varchar(30)                   not null,
    section  varchar(30)                   not null,
    `key`    varchar(60)                   not null,
    value    text                          not null,
    `system` enum ('0', '1') default '1'   not null,
    vision   varchar(10)     default 'rnd' not null,
    constraint lang
        unique (lang, module, section, `key`, vision)
);

create table if not exists zt_leave
(
    id            int unsigned auto_increment
        primary key,
    year          char(4)                          not null,
    begin         date                             not null,
    end           date                             not null,
    start         time                             not null,
    finish        time                             not null,
    hours         float(4, 1) unsigned default 0.0 not null,
    backDate      datetime                         not null,
    type          varchar(30)          default ''  not null,
    `desc`        text                             not null,
    status        varchar(30)          default ''  not null,
    createdBy     char(30)                         not null,
    createdDate   datetime                         not null,
    reviewedBy    char(30)                         not null,
    reviewedDate  datetime                         not null,
    level         int                              not null,
    assignedTo    varchar(30)                      not null,
    reviewers     text                             not null,
    backReviewers text                             not null
);

create index createdBy
    on zt_leave (createdBy);

create index status
    on zt_leave (status);

create index type
    on zt_leave (type);

create index year
    on zt_leave (year);

create table if not exists zt_lieu
(
    id           int unsigned auto_increment
        primary key,
    year         char(4)                          not null,
    begin        date                             not null,
    end          date                             not null,
    start        time                             not null,
    finish       time                             not null,
    hours        float(4, 1) unsigned default 0.0 not null,
    overtime     char(255)                        not null,
    trip         char(255)                        not null,
    `desc`       text                             not null,
    status       varchar(30)          default ''  not null,
    createdBy    char(30)                         not null,
    createdDate  datetime                         not null,
    reviewedBy   char(30)                         not null,
    reviewedDate datetime                         not null,
    level        int                              not null,
    assignedTo   varchar(30)                      not null,
    reviewers    text                             not null
);

create index createdBy
    on zt_lieu (createdBy);

create index status
    on zt_lieu (status);

create index year
    on zt_lieu (year);

create table if not exists zt_log
(
    id          int unsigned auto_increment
        primary key,
    objectType  varchar(30)  not null,
    objectID    int unsigned not null,
    action      int unsigned not null,
    date        datetime     not null,
    url         varchar(255) not null,
    contentType varchar(30)  not null,
    data        text         not null,
    result      text         not null
);

create index obejctID
    on zt_log (objectID);

create index objectType
    on zt_log (objectType);

create table if not exists zt_measqueue
(
    id          int unsigned auto_increment
        primary key,
    type        varchar(30)                 not null,
    mid         int unsigned                not null,
    status      varchar(255)                not null,
    logs        text                        null,
    execTime    varchar(10)                 not null,
    params      text                        null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    updateDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_measrecords
(
    id        int auto_increment
        primary key,
    type      varchar(30)         not null,
    mid       int                 not null,
    measCode  char(50) default '' not null,
    project   int unsigned        not null,
    product   int unsigned        not null,
    execution int unsigned        not null,
    params    text                not null,
    year      char(4)             not null,
    month     char(6)             not null,
    week      char(8)             not null,
    day       char(8)             not null,
    value     varchar(255)        not null,
    date      date                not null
);

create index product
    on zt_measrecords (product);

create index project
    on zt_measrecords (project);

create index time
    on zt_measrecords (year, month, day, week);

create table if not exists zt_meastemplate
(
    id          int auto_increment
        primary key,
    model       char(30)                    not null,
    name        varchar(255)                not null,
    content     mediumtext                  not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_meeting
(
    id          int unsigned auto_increment
        primary key,
    project     int                         not null,
    execution   int                         not null,
    name        varchar(255)                not null,
    type        varchar(255)                not null,
    begin       time                        not null,
    end         time                        not null,
    dept        int                         not null,
    mode        varchar(255)                not null,
    host        varchar(30)                 not null,
    participant text                        not null,
    date        date                        not null,
    room        int                         not null,
    minutes     text                        not null,
    minutedBy   varchar(30)                 not null,
    minutedDate datetime                    not null,
    objectType  varchar(30)                 not null,
    objectID    int                         not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_meetingroom
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    position    varchar(30)                 not null,
    seats       int                         not null,
    equipment   varchar(255)                not null,
    openTime    varchar(255)                not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_module
(
    id        int unsigned auto_increment
        primary key,
    root      int unsigned    default '0' not null,
    branch    int unsigned    default '0' not null,
    name      char(60)        default ''  not null,
    parent    int unsigned    default '0' not null,
    path      char(255)       default ''  not null,
    grade     int unsigned    default '0' not null,
    `order`   int unsigned    default '0' not null,
    type      char(30)                    not null,
    `from`    int unsigned    default '0' not null,
    owner     varchar(30)                 not null,
    collector text                        not null,
    short     varchar(30)                 not null,
    deleted   enum ('0', '1') default '0' not null
);

create index path
    on zt_module (path);

create index root
    on zt_module (root);

create index type
    on zt_module (type);

create table if not exists zt_mr
(
    id                 int unsigned auto_increment
        primary key,
    hostID             int unsigned                not null,
    sourceProject      varchar(50)                 not null,
    sourceBranch       varchar(100)                not null,
    targetProject      varchar(50)                 not null,
    targetBranch       varchar(100)                not null,
    mriid              int unsigned                not null,
    title              varchar(255)                not null,
    description        text                        not null,
    assignee           varchar(255)                not null,
    reviewer           varchar(255)                not null,
    approver           varchar(255)                not null,
    createdBy          varchar(30)                 not null,
    createdDate        datetime                    not null,
    editedBy           varchar(30)                 not null,
    editedDate         datetime                    not null,
    deleted            enum ('0', '1') default '0' not null,
    status             char(30)                    not null,
    mergeStatus        char(30)                    not null,
    approvalStatus     char(30)                    not null,
    needApproved       enum ('0', '1') default '0' not null,
    needCI             enum ('0', '1') default '0' not null,
    repoID             int unsigned                not null,
    jobID              int unsigned                not null,
    compileID          int unsigned                not null,
    compileStatus      char(30)                    not null,
    removeSourceBranch enum ('0', '1') default '0' not null,
    squash             enum ('0', '1') default '0' not null,
    synced             enum ('0', '1') default '1' not null,
    syncError          varchar(255)                not null,
    hasNoConflict      enum ('0', '1') default '0' not null,
    diffs              longtext                    null
);

create table if not exists zt_mrapproval
(
    id      int unsigned auto_increment
        primary key,
    mrID    int unsigned not null,
    account varchar(255) not null,
    date    datetime     not null,
    action  char(30)     not null,
    comment text         not null
);

create table if not exists zt_nc
(
    id           int unsigned auto_increment
        primary key,
    project      int unsigned                     not null,
    auditplan    int                              not null,
    listID       int                              not null,
    title        varchar(255)                     not null,
    `desc`       mediumtext                       not null,
    type         char(30)                         not null,
    status       varchar(30)     default 'active' not null,
    severity     char(30)                         not null,
    deadline     date                             not null,
    resolvedBy   varchar(30)                      not null,
    resolution   char(30)                         not null,
    resolvedDate date                             not null,
    closedBy     varchar(30)                      not null,
    closedDate   date                             not null,
    parent       int unsigned                     not null,
    assignedTo   varchar(30)                      not null,
    assignedDate date                             not null,
    activateDate date                             not null,
    createdBy    varchar(30)                      not null,
    createdDate  datetime                         not null,
    editedBy     varchar(30)                      not null,
    editedDate   datetime                         not null,
    deleted      enum ('0', '1') default '0'      not null
);

create table if not exists zt_notify
(
    id          int unsigned auto_increment
        primary key,
    objectType  varchar(50)                not null,
    objectID    int unsigned               not null,
    action      int                        not null,
    toList      varchar(255)               not null,
    ccList      text                       not null,
    subject     varchar(255)               not null,
    data        text                       not null,
    createdBy   char(30)                   not null,
    createdDate datetime                   not null,
    sendTime    datetime                   not null,
    status      varchar(10) default 'wait' not null,
    failReason  text                       not null
);

create index objectType_toList_status
    on zt_notify (objectType, toList, status);

create table if not exists zt_oauth
(
    account      varchar(30)  not null,
    openID       varchar(255) not null,
    providerType varchar(30)  not null,
    providerID   int unsigned not null
);

create index account
    on zt_oauth (account);

create index providerID
    on zt_oauth (providerID);

create index providerType
    on zt_oauth (providerType);

create table if not exists zt_object
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                not null,
    product     int                         not null,
    `from`      int                         not null,
    title       varchar(255)                not null,
    category    char(30)                    not null,
    version     varchar(255)                not null,
    type        enum ('reviewed', 'taged')  not null,
    `range`     text                        not null,
    data        text                        not null,
    storyEst    char(30)                    not null,
    taskEst     char(30)                    not null,
    requestEst  char(30)                    not null,
    testEst     char(30)                    not null,
    devEst      char(30)                    not null,
    designEst   char(30)                    not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_opportunity
(
    id                int unsigned auto_increment
        primary key,
    project           int unsigned                     not null,
    execution         int unsigned                     not null,
    name              varchar(255)                     not null,
    source            char(30)                         not null,
    type              char(30)                         not null,
    strategy          char(30)                         not null,
    status            varchar(30)     default 'active' not null,
    impact            int                              not null,
    chance            int                              not null,
    ratio             int                              not null,
    pri               char(30)                         not null,
    identifiedDate    date                             not null,
    assignedTo        varchar(30)                      not null,
    assignedDate      date                             not null,
    approvedDate      date                             not null,
    prevention        mediumtext                       not null,
    plannedClosedDate date                             not null,
    actualClosedDate  date                             not null,
    lib               int unsigned    default '0'      not null,
    `from`            int unsigned    default '0'      not null,
    version           int             default 1        not null,
    createdBy         varchar(30)                      not null,
    createdDate       datetime                         not null,
    editedBy          varchar(30)                      not null,
    editedDate        datetime                         not null,
    activatedBy       varchar(30)                      not null,
    activatedDate     datetime                         not null,
    closedBy          varchar(30)                      not null,
    closedDate        datetime                         not null,
    canceledBy        varchar(30)                      not null,
    canceledDate      datetime                         not null,
    cancelReason      char(30)                         not null,
    hangupedBy        varchar(30)                      not null,
    hangupedDate      datetime                         not null,
    resolution        mediumtext                       not null,
    resolvedBy        varchar(30)                      not null,
    resolvedDate      datetime                         not null,
    lastCheckedBy     varchar(30)                      not null,
    lastCheckedDate   datetime                         not null,
    deleted           enum ('0', '1') default '0'      not null
);

create table if not exists zt_overtime
(
    id           int unsigned auto_increment
        primary key,
    year         char(4)                          not null,
    begin        date                             not null,
    end          date                             not null,
    start        time                             not null,
    finish       time                             not null,
    hours        float(4, 1) unsigned default 0.0 not null,
    `leave`      varchar(255)                     not null,
    type         varchar(30)          default ''  not null,
    `desc`       text                             not null,
    status       varchar(30)          default ''  not null,
    rejectReason varchar(100)                     not null,
    createdBy    char(30)                         not null,
    createdDate  datetime                         not null,
    reviewedBy   char(30)                         not null,
    reviewedDate datetime                         not null,
    level        int                              not null,
    assignedTo   varchar(30)                      not null,
    reviewers    text                             not null
);

create index createdBy
    on zt_overtime (createdBy);

create index status
    on zt_overtime (status);

create index type
    on zt_overtime (type);

create index year
    on zt_overtime (year);

create table if not exists zt_pipeline
(
    id          int unsigned auto_increment
        primary key,
    type        char(30)                    not null,
    name        varchar(50)                 not null,
    url         varchar(255)                null,
    account     varchar(30)                 null,
    password    varchar(255)                not null,
    token       varchar(255)                null,
    private     char(32)                    null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_planstory
(
    plan    int unsigned not null,
    story   int unsigned not null,
    `order` int          not null,
    constraint plan_story
        unique (plan, story)
);

create table if not exists zt_process
(
    id           int unsigned auto_increment
        primary key,
    model        char(30)        default 'waterfall' not null,
    name         varchar(255)                        not null,
    type         char(30)                            not null,
    abbr         char(30)                            not null,
    `desc`       mediumtext                          not null,
    assignedTo   varchar(30)                         not null,
    status       varchar(30)                         not null,
    `order`      int                                 not null,
    createdBy    varchar(30)                         not null,
    createdDate  datetime                            not null,
    editedBy     varchar(30)                         not null,
    editedDate   datetime                            not null,
    assignedBy   varchar(30)                         not null,
    assignedDate datetime                            not null,
    deleted      enum ('0', '1') default '0'         not null
);

create table if not exists zt_product
(
    id             int unsigned auto_increment
        primary key,
    program        int unsigned                                        not null,
    name           varchar(90)                                         not null,
    code           varchar(45)                                         not null,
    bind           enum ('0', '1')                    default '0'      not null,
    line           int                                                 not null,
    type           varchar(30)                        default 'normal' not null,
    status         varchar(30)                        default ''       not null,
    subStatus      varchar(30)                        default ''       not null,
    `desc`         mediumtext                                          not null,
    PO             varchar(30)                                         not null,
    QD             varchar(30)                                         not null,
    RD             varchar(30)                                         not null,
    feedback       varchar(30)                                         not null,
    ticket         varchar(30)                                         not null,
    acl            enum ('open', 'private', 'custom') default 'open'   not null,
    whitelist      text                                                not null,
    reviewer       text                                                not null,
    createdBy      varchar(30)                                         not null,
    createdDate    datetime                                            not null,
    createdVersion varchar(20)                                         not null,
    `order`        int unsigned                                        not null,
    vision         varchar(10)                        default 'rnd'    not null,
    deleted        enum ('0', '1')                    default '0'      not null,
    allowFeedback  enum ('0', '1')                    default '0'      not null
);

create index acl
    on zt_product (acl);

create index `order`
    on zt_product (`order`);

create table if not exists zt_productplan
(
    id           int unsigned auto_increment
        primary key,
    product      int unsigned                                            not null,
    branch       int unsigned                                            not null,
    parent       int                                      default 0      not null,
    title        varchar(90)                                             not null,
    status       enum ('wait', 'doing', 'done', 'closed') default 'wait' not null,
    `desc`       mediumtext                                              not null,
    begin        date                                                    not null,
    end          date                                                    not null,
    `order`      text                                                    not null,
    closedReason varchar(20)                                             not null,
    createdBy    varchar(30)                                             not null,
    createdDate  datetime                                                not null,
    deleted      enum ('0', '1')                          default '0'    not null
);

create index end
    on zt_productplan (end);

create index product
    on zt_productplan (product);

create table if not exists zt_programactivity
(
    id          int auto_increment
        primary key,
    project     int unsigned                not null,
    execution   int unsigned                not null,
    process     int                         not null,
    activity    int                         not null,
    name        varchar(255)                not null,
    content     text                        not null,
    reason      varchar(255)                not null,
    result      char(30)                    not null,
    linkedBy    char(30)                    not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_programoutput
(
    id          int auto_increment
        primary key,
    project     int unsigned                not null,
    execution   int unsigned                not null,
    process     int                         not null,
    activity    int                         not null,
    output      int                         not null,
    content     text                        not null,
    name        varchar(255)                not null,
    reason      varchar(255)                not null,
    result      char(30)                    not null,
    linkedBy    char(30)                    not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_programprocess
(
    id          int auto_increment
        primary key,
    project     int unsigned                not null,
    process     int                         not null,
    name        varchar(255)                not null,
    type        char(30)                    not null,
    abbr        char(30)                    not null,
    `desc`      text                        not null,
    reason      varchar(255)                not null,
    linkedBy    char(30)                    not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_programreport
(
    id          int auto_increment
        primary key,
    template    int                         not null,
    project     int unsigned                not null,
    name        varchar(255)                not null,
    params      text                        not null,
    content     text                        not null,
    createdBy   char(30)                    not null,
    createdDate date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_project
(
    id             int unsigned auto_increment
        primary key,
    project        int                       default 0        not null,
    model          char(30)                                   not null,
    type           char(30)                  default 'sprint' not null,
    lifetime       char(30)                  default ''       not null,
    budget         varchar(30)               default '0'      not null,
    budgetUnit     char(30)                  default 'CNY'    not null,
    attribute      varchar(30)               default ''       not null,
    percent        float unsigned            default '0'      not null,
    milestone      enum ('0', '1')           default '0'      not null,
    output         text                                       not null,
    auth           char(30)                                   not null,
    parent         int unsigned              default '0'      not null,
    path           varchar(255)                               not null,
    grade          int unsigned                               not null,
    name           varchar(90)                                not null,
    code           varchar(45)                                not null,
    begin          date                                       not null,
    end            date                                       not null,
    realBegan      date                                       not null,
    realEnd        date                                       not null,
    days           int unsigned                               not null,
    status         varchar(10)                                not null,
    subStatus      varchar(30)               default ''       not null,
    pri            enum ('1', '2', '3', '4') default '1'      not null,
    `desc`         mediumtext                                 not null,
    version        int                                        not null,
    parentVersion  int                                        not null,
    planDuration   int                                        not null,
    realDuration   int                                        not null,
    openedBy       varchar(30)               default ''       not null,
    openedDate     datetime                                   not null,
    openedVersion  varchar(20)                                not null,
    lastEditedBy   varchar(30)               default ''       not null,
    lastEditedDate datetime                                   not null,
    closedBy       varchar(30)               default ''       not null,
    closedDate     datetime                                   not null,
    canceledBy     varchar(30)               default ''       not null,
    canceledDate   datetime                                   not null,
    suspendedDate  date                                       not null,
    PO             varchar(30)               default ''       not null,
    PM             varchar(30)               default ''       not null,
    QD             varchar(30)               default ''       not null,
    RD             varchar(30)               default ''       not null,
    team           varchar(90)                                not null,
    acl            char(30)                  default 'open'   not null,
    whitelist      text                                       not null,
    `order`        int unsigned                               not null,
    vision         varchar(10)               default 'rnd'    not null,
    displayCards   int                       default 0        not null,
    fluidBoard     enum ('0', '1')           default '0'      not null,
    colWidth       int                       default 264      not null,
    minColWidth    int                       default 180      not null,
    maxColWidth    int                       default 384      not null,
    deleted        enum ('0', '1')           default '0'      not null
);

create index acl
    on zt_project (acl);

create index begin
    on zt_project (begin);

create index end
    on zt_project (end);

create index `order`
    on zt_project (`order`);

create index parent
    on zt_project (parent);

create index status
    on zt_project (status);

create table if not exists zt_projectadmin
(
    `group`    int      not null,
    account    char(30) not null,
    programs   text     not null,
    projects   text     not null,
    products   text     not null,
    executions text     not null,
    constraint group_account
        unique (`group`, account)
);

create table if not exists zt_projectcase
(
    project int unsigned default '0' not null,
    product int unsigned default '0' not null,
    `case`  int unsigned default '0' not null,
    count   int unsigned default '1' not null,
    version int          default 1   not null,
    `order` int unsigned             not null,
    constraint project
        unique (project, `case`)
);

create table if not exists zt_projectproduct
(
    project int unsigned not null,
    product int unsigned not null,
    branch  int unsigned not null,
    plan    varchar(255) not null,
    primary key (project, product, branch)
);

create table if not exists zt_projectspec
(
    project   int                         not null,
    version   int                         not null,
    name      varchar(255)                not null,
    milestone enum ('0', '1') default '0' not null,
    begin     date                        not null,
    end       date                        not null,
    constraint project
        unique (project, version)
);

create table if not exists zt_projectstory
(
    project int unsigned default '0' not null,
    product int unsigned             not null,
    branch  int unsigned             not null,
    story   int unsigned default '0' not null,
    version int          default 1   not null,
    `order` int unsigned             not null,
    constraint project
        unique (project, story)
);

create index story
    on zt_projectstory (story);

create table if not exists zt_projectuseinfo
(
    id          int unsigned auto_increment
        primary key,
    feedback    int unsigned    default '0' not null,
    serverOS    varchar(255)                not null,
    serverCPU   varchar(255)                not null,
    middleware  varchar(255)                not null,
    `database`  varchar(255)                not null,
    terminalOS  varchar(255)                not null,
    terminalCPU varchar(255)                not null,
    browser     varchar(255)                not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_relation
(
    id        int auto_increment
        primary key,
    project   int      not null,
    product   int      not null,
    execution int      not null,
    AType     char(30) not null,
    AID       int      not null,
    AVersion  char(30) not null,
    relation  char(30) not null,
    BType     char(30) not null,
    BID       int      not null,
    BVersion  char(30) not null,
    extra     char(30) not null,
    constraint relation
        unique (product, relation, AType, BType, AID, BID)
);

create table if not exists zt_relationoftasks
(
    id          int unsigned auto_increment
        primary key,
    execution   int unsigned          not null,
    pretask     int unsigned          not null,
    `condition` enum ('begin', 'end') not null,
    task        int unsigned          not null,
    action      enum ('begin', 'end') not null
);

create index relationoftasks
    on zt_relationoftasks (execution, task);

create table if not exists zt_release
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                     not null,
    product     int unsigned    default '0'      not null,
    branch      int unsigned    default '0'      not null,
    build       int unsigned                     not null,
    name        varchar(255)    default ''       not null,
    marker      enum ('0', '1') default '0'      not null,
    date        date                             not null,
    stories     text                             not null,
    bugs        text                             not null,
    leftBugs    text                             not null,
    `desc`      mediumtext                       not null,
    mailto      text                             null,
    notify      varchar(255)                     null,
    status      varchar(20)     default 'normal' not null,
    subStatus   varchar(30)     default ''       not null,
    createdBy   varchar(30)                      not null,
    createdDate datetime                         not null,
    deleted     enum ('0', '1') default '0'      not null
);

create index build
    on zt_release (build);

create index product
    on zt_release (product);

create table if not exists zt_repo
(
    id                 int auto_increment
        primary key,
    product            varchar(255)                    not null,
    name               varchar(255)                    not null,
    path               varchar(255)                    not null,
    prefix             varchar(100)                    not null,
    encoding           varchar(20)                     not null,
    SCM                varchar(10)                     not null,
    client             varchar(100)                    not null,
    serviceHost        varchar(50)                     not null,
    serviceProject     varchar(100)                    not null,
    commits            int unsigned                    not null,
    account            varchar(30)                     not null,
    password           varchar(30)                     not null,
    encrypt            varchar(30)     default 'plain' not null,
    acl                text                            not null,
    synced             int             default 0       not null,
    lastSync           datetime                        not null,
    `desc`             text                            not null,
    extra              char(30)                        not null,
    preMerge           enum ('0', '1') default '0'     not null,
    job                int unsigned                    not null,
    fileServerUrl      text                            null,
    fileServerAccount  varchar(40)     default ''      not null,
    fileServerPassword varchar(100)    default ''      not null,
    deleted            int                             not null
);

create table if not exists zt_repobranch
(
    repo     int unsigned not null,
    revision int unsigned not null,
    branch   varchar(255) not null,
    constraint repo_revision_branch
        unique (repo, revision, branch)
);

create index branch
    on zt_repobranch (branch);

create index revision
    on zt_repobranch (revision);

create table if not exists zt_repofiles
(
    id       int unsigned auto_increment
        primary key,
    repo     int unsigned not null,
    revision int unsigned not null,
    path     varchar(255) not null,
    parent   varchar(255) not null,
    type     varchar(20)  not null,
    action   char         not null
);

create index parent
    on zt_repofiles (parent);

create index path
    on zt_repofiles (path);

create index repo
    on zt_repofiles (repo);

create index revision
    on zt_repofiles (revision);

create table if not exists zt_repohistory
(
    id        int auto_increment
        primary key,
    repo      int          not null,
    revision  varchar(40)  not null,
    commit    int unsigned not null,
    comment   text         not null,
    committer varchar(100) not null,
    time      datetime     not null
);

create index repo
    on zt_repohistory (repo);

create index revision
    on zt_repohistory (revision);

create table if not exists zt_report
(
    id        int auto_increment
        primary key,
    code      varchar(100)  not null,
    name      text          not null,
    module    varchar(100)  not null,
    `sql`     text          not null,
    vars      text          not null,
    langs     text          not null,
    params    text          not null,
    step      int default 2 not null,
    `desc`    text          not null,
    addedBy   char(30)      not null,
    addedDate datetime      not null,
    constraint code
        unique (code)
);

create table if not exists zt_researchplan
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                                                                     not null,
    name        varchar(255)                                                                     not null,
    customer    varchar(255)                                                                     not null,
    stakeholder varchar(255)                                                                     not null,
    objective   varchar(255)                                                                     not null,
    begin       datetime                                                                         not null,
    end         datetime                                                                         not null,
    location    varchar(255)                                                                     not null,
    team        varchar(255)                                                                     not null,
    method      enum ('', 'videoConference', 'interview', 'questionnaire', 'telephoneInterview') not null,
    outline     mediumtext                                                                       not null,
    schedule    mediumtext                                                                       not null,
    createdBy   varchar(30)                                                                      not null,
    createdDate datetime                                                                         not null,
    editedBy    varchar(30)                                                                      not null,
    editedDate  datetime                                                                         not null,
    deleted     enum ('0', '1') default '0'                                                      not null
);

create table if not exists zt_researchreport
(
    id              int unsigned auto_increment
        primary key,
    project         int unsigned                                                                     not null,
    relatedPlan     int unsigned                                                                     not null,
    title           varchar(255)                                                                     not null,
    author          varchar(30)                                                                      not null,
    content         mediumtext                                                                       not null,
    customer        varchar(255)                                                                     not null,
    researchObjects varchar(255)                                                                     not null,
    begin           datetime                                                                         not null,
    end             datetime                                                                         not null,
    location        varchar(255)                                                                     not null,
    method          enum ('', 'videoConference', 'interview', 'questionnaire', 'telephoneInterview') not null,
    createdBy       varchar(30)                                                                      not null,
    createdDate     datetime                                                                         not null,
    editedBy        varchar(30)                                                                      not null,
    editedDate      datetime                                                                         not null,
    deleted         enum ('0', '1') default '0'                                                      not null
);

create table if not exists zt_review
(
    id               int unsigned auto_increment
        primary key,
    project          int unsigned                not null,
    title            varchar(255)                not null,
    object           int                         not null,
    template         int                         not null,
    doc              int                         null,
    docVersion       int                         null,
    status           char(30)                    not null,
    reviewedBy       varchar(255)                not null,
    auditedBy        varchar(255)                not null,
    createdBy        char(30)                    not null,
    createdDate      date                        not null,
    deadline         date                        not null,
    lastReviewedBy   varchar(255)                null,
    lastReviewedDate date                        not null,
    lastAuditedBy    varchar(255)                not null,
    lastAuditedDate  date                        not null,
    lastEditedBy     varchar(255)                not null,
    lastEditedDate   date                        not null,
    result           char(30)                    not null,
    auditResult      char(30)                    not null,
    deleted          enum ('0', '1') default '0' not null
);

create table if not exists zt_reviewcl
(
    id           int unsigned auto_increment
        primary key,
    title        varchar(255)                not null,
    object       char(30)                    not null,
    category     char(30)                    not null,
    assignedTo   varchar(30)                 not null,
    `order`      int             default 0   null,
    status       varchar(30)                 not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    assignedBy   varchar(30)                 not null,
    assignedDate datetime                    not null,
    deleted      enum ('0', '1') default '0' not null
);

create table if not exists zt_reviewissue
(
    id             int auto_increment
        primary key,
    project        int unsigned                     not null,
    review         int                              not null,
    approval       int                              not null,
    injection      int                              not null,
    identify       int                              not null,
    type           char(30)        default 'review' not null,
    listID         int                              not null,
    title          varchar(255)                     not null,
    opinion        varchar(255)                     not null,
    opinionDate    date                             not null,
    status         char(30)                         not null,
    resolution     char(30)                         not null,
    resolutionBy   char(30)                         not null,
    resolutionDate date                             not null,
    createdBy      char(30)                         not null,
    createdDate    date                             not null,
    deleted        enum ('0', '1') default '0'      not null
);

create table if not exists zt_reviewlist
(
    id           int unsigned auto_increment
        primary key,
    title        varchar(255)                not null,
    object       char(30)                    not null,
    category     char(30)                    not null,
    assignedTo   varchar(30)                 not null,
    status       varchar(30)                 not null,
    createdBy    varchar(30)                 not null,
    createdDate  datetime                    not null,
    editedBy     varchar(30)                 not null,
    editedDate   datetime                    not null,
    assignedBy   varchar(30)                 not null,
    assignedDate datetime                    not null,
    deleted      enum ('0', '1') default '0' not null
);

create table if not exists zt_reviewresult
(
    id          int auto_increment
        primary key,
    review      int                       not null,
    type        char(30) default 'review' not null,
    result      char(30)                  not null,
    opinion     text                      not null,
    reviewer    char(30)                  not null,
    remainIssue char(30)                  not null,
    createdDate date                      not null,
    consumed    float                     not null,
    constraint reviewer
        unique (review, reviewer, type)
);

create table if not exists zt_risk
(
    id                int unsigned auto_increment
        primary key,
    project           varchar(255)                     not null,
    execution         int unsigned                     not null,
    name              varchar(255)                     not null,
    source            char(30)                         not null,
    category          char(30)                         not null,
    strategy          char(30)                         not null,
    status            varchar(30)     default 'active' not null,
    impact            char(30)                         not null,
    probability       char(30)                         not null,
    rate              char(30)                         not null,
    pri               char(30)                         not null,
    identifiedDate    date                             not null,
    prevention        mediumtext                       not null,
    remedy            mediumtext                       not null,
    plannedClosedDate date                             not null,
    actualClosedDate  date                             not null,
    lib               int unsigned    default '0'      not null,
    `from`            int unsigned    default '0'      not null,
    version           int             default 1        not null,
    createdBy         varchar(30)                      not null,
    createdDate       datetime                         not null,
    editedBy          varchar(30)                      not null,
    editedDate        datetime                         not null,
    resolution        mediumtext                       not null,
    resolvedBy        varchar(30)                      not null,
    activateBy        varchar(30)                      not null,
    activateDate      date                             not null,
    assignedTo        varchar(30)                      not null,
    closedBy          varchar(30)                      not null,
    closedDate        date                             not null,
    cancelBy          varchar(30)                      not null,
    cancelDate        date                             not null,
    cancelReason      char(30)                         not null,
    hangupBy          varchar(30)                      not null,
    hangupDate        date                             not null,
    trackedBy         varchar(30)                      not null,
    trackedDate       date                             not null,
    assignedDate      date                             not null,
    approvedDate      date                             not null,
    deleted           enum ('0', '1') default '0'      not null
);

create table if not exists zt_riskissue
(
    risk  int unsigned not null,
    issue int unsigned not null,
    constraint risk_issue
        unique (risk, issue)
);

create table if not exists zt_score
(
    id       int unsigned auto_increment
        primary key,
    account  varchar(30)             not null,
    module   varchar(30)  default '' not null,
    method   varchar(30)             not null,
    `desc`   varchar(250) default '' not null,
    `before` int          default 0  not null,
    score    int          default 0  not null,
    after    int          default 0  not null,
    time     datetime                not null
);

create index account
    on zt_score (account);

create index method
    on zt_score (method);

create index model
    on zt_score (module);

create table if not exists zt_searchdict
(
    `key` int unsigned not null,
    value char(3)      not null,
    primary key (`key`)
);

create table if not exists zt_searchindex
(
    id         int unsigned auto_increment
        primary key,
    vision     varchar(10) default 'rnd' not null,
    objectType char(20)                  not null,
    objectID   int                       not null,
    title      text                      not null,
    content    text                      not null,
    addedDate  datetime                  not null,
    editedDate datetime                  not null,
    constraint object
        unique (objectType, objectID)
);

create index addedDate
    on zt_searchindex (addedDate);

create fulltext index title_content
    on zt_searchindex (title, content);

create table if not exists zt_serverroom
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(128)                not null,
    city        varchar(128)                not null,
    line        varchar(20)                 not null,
    bandwidth   varchar(128)                not null,
    provider    varchar(128)                not null,
    owner       varchar(30)                 not null,
    createdBy   char(30)                    not null,
    createdDate datetime                    not null,
    editedBy    char(30)                    not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_service
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    external    enum ('0', '1') default '0' not null,
    port        int unsigned                not null,
    entry       varchar(255)                not null,
    deploy      varchar(255)                not null,
    version     varchar(64)                 not null,
    color       char(7)                     not null,
    `desc`      mediumtext                  null,
    dept        varchar(128)                not null,
    devel       varchar(30)                 not null,
    qa          varchar(30)                 not null,
    ops         varchar(30)                 not null,
    hosts       text                        null,
    softName    varchar(128)                not null,
    softVersion varchar(128)                not null,
    type        varchar(20)                 not null,
    createdBy   char(30)                    not null,
    createdDate datetime                    not null,
    editedBy    char(30)                    not null,
    editedDate  datetime                    not null,
    parent      int unsigned    default '0' not null,
    path        char(255)       default ''  not null,
    grade       int unsigned    default '0' not null,
    `order`     int unsigned    default '0' not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_solutions
(
    id         int auto_increment
        primary key,
    project    int unsigned                not null,
    execution  int unsigned                not null,
    contents   text                        not null comment '问题描述',
    support    text                        not null comment '是否需要高层支持',
    measures   text                        not null comment '解决建议',
    type       char(30)                    not null,
    addedBy    varchar(30)                 not null,
    addedDate  date                        not null,
    editedBy   varchar(30)                 not null,
    editedDate date                        not null,
    deleted    enum ('0', '1') default '0' not null
);

create table if not exists zt_sqlview
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(90)                 not null,
    code        varchar(45)                 not null,
    `sql`       text                        not null,
    `desc`      text                        not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_stage
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(255)                not null,
    percent     varchar(255)                not null,
    type        varchar(255)                not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_stakeholder
(
    id          int auto_increment
        primary key,
    objectID    int             not null,
    objectType  char(30)        not null,
    user        char(30)        not null,
    type        char(30)        not null,
    `key`       enum ('0', '1') not null,
    `from`      char(30)        not null,
    createdBy   char(30)        not null,
    createdDate date            not null,
    editedBy    char(30)        not null,
    editedDate  date            not null,
    deleted     enum ('0', '1') not null
);

create index objectID
    on zt_stakeholder (objectID);

create table if not exists zt_story
(
    id               int unsigned auto_increment
        primary key,
    vision           varchar(10)                                                                                                                 default 'rnd'                 not null,
    parent           int                                                                                                                         default 0                     not null,
    product          int unsigned                                                                                                                default '0'                   not null,
    branch           int unsigned                                                                                                                default '0'                   not null,
    module           int unsigned                                                                                                                default '0'                   not null,
    plan             text                                                                                                                                                      null,
    source           varchar(20)                                                                                                                                               not null,
    sourceNote       varchar(255)                                                                                                                                              not null,
    fromBug          int unsigned                                                                                                                default '0'                   not null,
    feedback         int unsigned                                                                                                                default '0'                   not null,
    title            varchar(255)                                                                                                                                              not null,
    keywords         varchar(255)                                                                                                                                              not null,
    type             varchar(30)                                                                                                                 default 'story'               not null,
    category         varchar(30)                                                                                                                 default 'feature'             not null,
    pri              int unsigned                                                                                                                default '3'                   not null,
    estimate         float unsigned                                                                                                                                            not null,
    status           enum ('', 'changing', 'active', 'draft', 'reviewing', 'closed')                                                             default ''                    not null,
    subStatus        varchar(30)                                                                                                                 default ''                    not null,
    color            char(7)                                                                                                                                                   not null,
    stage            enum ('', 'wait', 'planned', 'projected', 'developing', 'developed', 'testing', 'tested', 'verified', 'released', 'closed') default 'wait'                not null,
    stagedBy         char(30)                                                                                                                                                  not null,
    mailto           text                                                                                                                                                      null,
    lib              int unsigned                                                                                                                default '0'                   not null,
    fromStory        int unsigned                                                                                                                default '0'                   not null,
    fromVersion      int                                                                                                                         default 1                     not null,
    openedBy         varchar(30)                                                                                                                 default ''                    not null,
    openedDate       datetime                                                                                                                                                  not null,
    assignedTo       varchar(30)                                                                                                                 default ''                    not null,
    assignedDate     datetime                                                                                                                                                  not null,
    approvedDate     date                                                                                                                                                      not null,
    lastEditedBy     varchar(30)                                                                                                                 default ''                    not null,
    lastEditedDate   datetime                                                                                                                                                  not null,
    changedBy        varchar(30)                                                                                                                                               not null,
    changedDate      datetime                                                                                                                                                  not null,
    reviewedBy       varchar(255)                                                                                                                                              not null,
    reviewedDate     datetime                                                                                                                    default '0000-00-00 00:00:00' not null,
    closedBy         varchar(30)                                                                                                                 default ''                    not null,
    closedDate       datetime                                                                                                                                                  not null,
    closedReason     varchar(30)                                                                                                                                               not null,
    activatedDate    datetime                                                                                                                                                  not null,
    toBug            int unsigned                                                                                                                                              not null,
    childStories     varchar(255)                                                                                                                                              not null,
    linkStories      varchar(255)                                                                                                                                              not null,
    linkRequirements varchar(255)                                                                                                                                              not null,
    duplicateStory   int unsigned                                                                                                                                              not null,
    version          int                                                                                                                         default 1                     not null,
    storyChanged     enum ('0', '1')                                                                                                             default '0'                   not null,
    feedbackBy       varchar(100)                                                                                                                                              not null,
    notifyEmail      varchar(100)                                                                                                                                              not null,
    URChanged        enum ('0', '1')                                                                                                             default '0'                   not null,
    deleted          enum ('0', '1')                                                                                                             default '0'                   not null
);

create index assignedTo
    on zt_story (assignedTo);

create index product
    on zt_story (product);

create index status
    on zt_story (status);

create table if not exists zt_storyestimate
(
    story      int         not null,
    round      int         not null,
    estimate   text        not null,
    average    float       not null,
    openedBy   varchar(30) not null,
    openedDate datetime    not null,
    constraint story
        unique (story, round)
);

create table if not exists zt_storyreview
(
    story      int         not null,
    version    int         not null,
    reviewer   varchar(30) not null,
    result     varchar(30) not null,
    reviewDate datetime    not null,
    constraint story
        unique (story, version, reviewer)
);

create table if not exists zt_storyspec
(
    story   int          not null,
    version int          not null,
    title   varchar(255) not null,
    spec    mediumtext   not null,
    verify  mediumtext   not null,
    files   text         not null,
    constraint story
        unique (story, version)
);

create table if not exists zt_storystage
(
    story    int unsigned not null,
    branch   int unsigned not null,
    stage    varchar(50)  not null,
    stagedBy char(30)     not null,
    constraint story_branch
        unique (story, branch)
);

create index story
    on zt_storystage (story);

create table if not exists zt_suitecase
(
    suite   int unsigned not null,
    product int unsigned not null,
    `case`  int unsigned not null,
    version int unsigned not null,
    constraint suitecase
        unique (suite, `case`)
);

create table if not exists zt_task
(
    id             int unsigned auto_increment
        primary key,
    project        int unsigned                                                               not null,
    parent         int                                                         default 0      not null,
    execution      int unsigned                                                default '0'    not null,
    module         int unsigned                                                default '0'    not null,
    design         int unsigned                                                               not null,
    story          int unsigned                                                default '0'    not null,
    storyVersion   int                                                         default 1      not null,
    designVersion  int unsigned                                                               not null,
    fromBug        int unsigned                                                default '0'    not null,
    feedback       int unsigned                                                               not null,
    fromIssue      int unsigned                                                default '0'    not null,
    workcodelines  int unsigned                                                default '0'    null,
    name           varchar(255)                                                               not null,
    type           varchar(20)                                                                not null,
    mode           varchar(10)                                                                not null,
    pri            int unsigned                                                default '0'    not null,
    estimate       float unsigned                                                             not null,
    consumed       float unsigned                                                             not null,
    `left`         float unsigned                                                             not null,
    deadline       date                                                                       not null,
    status         enum ('wait', 'doing', 'done', 'pause', 'cancel', 'closed') default 'wait' not null,
    subStatus      varchar(30)                                                 default ''     not null,
    color          char(7)                                                                    not null,
    mailto         text                                                                       null,
    `desc`         mediumtext                                                                 not null,
    version        int                                                                        not null,
    openedBy       varchar(30)                                                                not null,
    openedDate     datetime                                                                   not null,
    assignedTo     varchar(30)                                                                not null,
    assignedDate   datetime                                                                   not null,
    estStarted     date                                                                       not null,
    realStarted    datetime                                                                   not null,
    finishedBy     varchar(30)                                                                not null,
    finishedDate   datetime                                                                   not null,
    finishedList   text                                                                       not null,
    canceledBy     varchar(30)                                                                not null,
    canceledDate   datetime                                                                   not null,
    closedBy       varchar(30)                                                                not null,
    closedDate     datetime                                                                   not null,
    planDuration   int                                                                        not null,
    realDuration   int                                                                        not null,
    closedReason   varchar(30)                                                                not null,
    lastEditedBy   varchar(30)                                                                not null,
    lastEditedDate datetime                                                                   not null,
    activatedDate  datetime                                                                   not null,
    `order`        int unsigned                                                               not null,
    repo           int unsigned                                                               not null,
    mr             int unsigned                                                               not null,
    entry          varchar(255)                                                               not null,
    `lines`        varchar(10)                                                                not null,
    v1             varchar(40)                                                                not null,
    v2             varchar(40)                                                                not null,
    deleted        enum ('0', '1')                                             default '0'    not null,
    vision         varchar(10)                                                 default 'rnd'  not null
);

create index assignedTo
    on zt_task (assignedTo);

create index execution
    on zt_task (execution);

create index `order`
    on zt_task (`order`);

create index parent
    on zt_task (parent);

create index story
    on zt_task (story);

create table if not exists zt_taskestimate
(
    id       int unsigned auto_increment
        primary key,
    task     int unsigned   default '0' not null,
    date     date                       not null,
    `left`   float unsigned default '0' not null,
    consumed float unsigned             not null,
    account  char(30)       default ''  not null,
    work     text                       null,
    `order`  int unsigned   default '0' not null
);

create index task
    on zt_taskestimate (task);

create table if not exists zt_taskspec
(
    task       int          not null,
    version    int          not null,
    name       varchar(255) not null,
    estStarted date         not null,
    deadline   date         not null,
    constraint task
        unique (task, version)
);

create table if not exists zt_taskteam
(
    id       int unsigned auto_increment
        primary key,
    task     int unsigned                                  not null,
    account  char(30)                                      not null,
    estimate decimal(12, 2)                                not null,
    consumed decimal(12, 2)                                not null,
    `left`   decimal(12, 2)                                not null,
    transfer char(30)                                      not null,
    status   enum ('wait', 'doing', 'done') default 'wait' not null,
    `order`  int                                           not null
);

create index task
    on zt_taskteam (task);

create table if not exists zt_team
(
    id       int unsigned auto_increment
        primary key,
    root     int unsigned                          default '0'          not null,
    type     enum ('project', 'task', 'execution') default 'project'    not null,
    account  char(30)                              default ''           not null,
    role     char(30)                              default ''           not null,
    position varchar(30)                                                not null,
    limited  char(8)                               default 'no'         not null,
    `join`   date                                  default '0000-00-00' not null,
    days     int unsigned                                               not null,
    hours    float(3, 1) unsigned                  default 0.0          not null,
    estimate decimal(12, 2) unsigned               default 0.00         not null,
    consumed decimal(12, 2) unsigned               default 0.00         not null,
    `left`   decimal(12, 2) unsigned               default 0.00         not null,
    `order`  int                                   default 0            not null,
    constraint team
        unique (root, type, account)
);

create table if not exists zt_testreport
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned    not null,
    product     int unsigned    not null,
    execution   int unsigned    not null,
    tasks       varchar(255)    not null,
    builds      varchar(255)    not null,
    title       varchar(255)    not null,
    begin       date            not null,
    end         date            not null,
    owner       char(30)        not null,
    members     text            not null,
    stories     text            not null,
    bugs        text            not null,
    cases       text            not null,
    report      text            not null,
    objectType  varchar(20)     not null,
    objectID    int unsigned    not null,
    createdBy   char(30)        not null,
    createdDate datetime        not null,
    deleted     enum ('0', '1') not null
);

create table if not exists zt_testresult
(
    id          int unsigned auto_increment
        primary key,
    run         int unsigned   not null,
    `case`      int unsigned   not null,
    version     int unsigned   not null,
    job         int unsigned   not null,
    compile     int unsigned   not null,
    caseResult  char(30)       not null,
    stepResults text           not null,
    lastRunner  varchar(30)    not null,
    date        datetime       not null,
    duration    float          not null,
    xml         text           not null,
    bug         int default -1 not null,
    deploy      int unsigned   not null
);

create index `case`
    on zt_testresult (`case`);

create index run
    on zt_testresult (run);

create index version
    on zt_testresult (version);

create table if not exists zt_testrun
(
    id            int unsigned auto_increment
        primary key,
    task          int unsigned default '0' not null,
    `case`        int unsigned default '0' not null,
    version       int unsigned default '0' not null,
    assignedTo    char(30)     default ''  not null,
    lastRunner    varchar(30)              not null,
    lastRunDate   datetime                 not null,
    lastRunResult char(30)                 not null,
    status        char(30)                 not null,
    constraint task
        unique (task, `case`)
);

create table if not exists zt_testsuite
(
    id             int unsigned auto_increment
        primary key,
    project        int unsigned             not null,
    product        int unsigned             not null,
    name           varchar(255)             not null,
    `desc`         mediumtext               not null,
    type           varchar(20)              not null,
    `order`        int unsigned default '0' not null,
    addedBy        char(30)                 not null,
    addedDate      datetime                 not null,
    lastEditedBy   char(30)                 not null,
    lastEditedDate datetime                 not null,
    deleted        enum ('0', '1')          not null
);

create index product
    on zt_testsuite (product);

create table if not exists zt_testtask
(
    id               int unsigned auto_increment
        primary key,
    project          int unsigned                                             not null,
    product          int unsigned                                             not null,
    parent           int                                                      not null,
    name             char(90)                                                 not null,
    execution        int unsigned                              default '0'    not null,
    build            char(30)                                                 not null,
    type             varchar(255)                              default ''     not null,
    owner            varchar(30)                                              not null,
    pri              int unsigned                              default '0'    not null,
    begin            date                                                     not null,
    end              date                                                     not null,
    realFinishedDate datetime                                                 not null,
    mailto           text                                                     null,
    `desc`           mediumtext                                               not null,
    report           text                                                     not null,
    status           enum ('blocked', 'doing', 'wait', 'done') default 'wait' not null,
    testreport       int unsigned                                             not null,
    auto             varchar(10)                               default 'no'   not null,
    subStatus        varchar(30)                               default ''     not null,
    createdBy        varchar(30)                                              not null,
    createdDate      datetime                                                 not null,
    deleted          enum ('0', '1')                           default '0'    not null
);

create index build
    on zt_testtask (build);

create index product
    on zt_testtask (product);

create table if not exists zt_ticket
(
    id             int unsigned auto_increment
        primary key,
    product        int unsigned                not null,
    module         int unsigned                not null,
    title          varchar(255)                not null,
    type           varchar(30)                 not null,
    `desc`         text                        not null,
    openedBuild    varchar(255)                not null,
    feedback       int                         not null,
    assignedTo     varchar(255)                not null,
    assignedDate   datetime                    not null,
    realStarted    datetime                    not null,
    startedBy      varchar(255)                not null,
    startedDate    datetime                    not null,
    deadline       date                        not null,
    pri            int unsigned    default '0' not null,
    estimate       float unsigned              not null,
    `left`         float unsigned              not null,
    status         varchar(30)                 not null,
    openedBy       varchar(30)                 not null,
    openedDate     datetime                    not null,
    activatedCount int                         not null,
    activatedBy    varchar(30)                 not null,
    activatedDate  datetime                    not null,
    closedBy       varchar(30)                 not null,
    closedDate     datetime                    not null,
    closedReason   varchar(30)                 not null,
    finishedBy     varchar(30)                 not null,
    finishedDate   datetime                    not null,
    resolvedBy     varchar(30)                 not null,
    resolvedDate   datetime                    not null,
    resolution     varchar(1000)               not null,
    editedBy       varchar(30)                 not null,
    editedDate     datetime                    not null,
    keywords       varchar(255)                not null,
    repeatTicket   int             default 0   not null,
    mailto         varchar(255)                not null,
    deleted        enum ('0', '1') default '0' not null
);

create index product
    on zt_ticket (product);

create table if not exists zt_ticketrelation
(
    id         int unsigned auto_increment
        primary key,
    ticketId   int unsigned not null,
    objectId   int          not null,
    objectType varchar(100) not null
);

create index ticketId
    on zt_ticketrelation (ticketId);

create table if not exists zt_ticketsource
(
    id          int unsigned auto_increment
        primary key,
    ticketId    int unsigned not null,
    customer    varchar(100) not null,
    contact     varchar(100) not null,
    notifyEmail varchar(100) not null,
    createdDate datetime     not null
);

create index ticketId
    on zt_ticketsource (ticketId);

create table if not exists zt_todo
(
    id           int unsigned auto_increment
        primary key,
    account      char(30)                                                not null,
    date         date                                                    not null,
    begin        int unsigned zerofill                                   not null,
    end          int unsigned zerofill                                   not null,
    feedback     int unsigned                                            not null,
    type         char(15)                                                not null,
    cycle        int unsigned                             default '0'    not null,
    idvalue      int unsigned                             default '0'    not null,
    pri          int unsigned                                            not null,
    name         char(150)                                               not null,
    `desc`       mediumtext                                              not null,
    status       enum ('wait', 'doing', 'done', 'closed') default 'wait' not null,
    private      int                                                     not null,
    config       varchar(255)                                            not null,
    assignedTo   varchar(30)                              default ''     not null,
    assignedBy   varchar(30)                              default ''     not null,
    assignedDate datetime                                                not null,
    finishedBy   varchar(30)                              default ''     not null,
    finishedDate datetime                                                not null,
    closedBy     varchar(30)                              default ''     not null,
    closedDate   datetime                                                not null,
    deleted      enum ('0', '1')                          default '0'    not null,
    vision       varchar(10)                              default 'rnd'  not null
);

create index account
    on zt_todo (account);

create index assignedTo
    on zt_todo (assignedTo);

create index date
    on zt_todo (date);

create index finishedBy
    on zt_todo (finishedBy);

create table if not exists zt_traincategory
(
    id      int unsigned auto_increment
        primary key,
    name    char(30)        default ''  not null,
    parent  int unsigned    default '0' not null,
    path    char(255)       default ''  not null,
    grade   int                         not null,
    `order` int                         not null,
    deleted enum ('0', '1') default '0' not null
);

create index parent
    on zt_traincategory (parent);

create index path
    on zt_traincategory (path);

create table if not exists zt_traincontents
(
    id          int unsigned auto_increment
        primary key,
    code        varchar(50)              not null,
    course      int unsigned default '0' not null,
    name        varchar(255)             not null,
    type        varchar(30)              not null,
    parent      int unsigned default '0' not null,
    path        char(255)    default ''  not null,
    `desc`      text                     not null,
    `order`     int                      not null,
    createdBy   char(30)                 not null,
    createdDate datetime                 not null,
    editedBy    varchar(30)              not null,
    editedDate  datetime                 not null,
    deleted     int                      not null
);

create table if not exists zt_traincourse
(
    id          int auto_increment
        primary key,
    code        varchar(50)                 not null,
    category    int                         not null,
    name        varchar(255)                not null,
    status      varchar(10)                 not null,
    teacher     varchar(30)     default ''  not null,
    `desc`      mediumtext                  not null,
    createdBy   varchar(255)                not null,
    createdDate date                        not null,
    editedBy    varchar(255)                not null,
    editedDate  date                        not null,
    deleted     enum ('0', '1') default '0' not null
);

create table if not exists zt_trainplan
(
    id          int unsigned auto_increment
        primary key,
    project     int unsigned                                not null,
    name        varchar(255)                                not null,
    begin       date                                        not null,
    end         date                                        not null,
    place       varchar(255)                                not null,
    trainee     text                                        not null,
    lecturer    varchar(20)                                 not null,
    type        enum ('inside', 'outside') default 'inside' not null,
    status      varchar(20)                                 not null,
    summary     mediumtext                                  not null,
    createdBy   char(30)                                    null,
    createdDate datetime                                    not null,
    editedBy    varchar(30)                                 not null,
    editedDate  datetime                                    not null,
    deleted     enum ('0', '1')            default '0'      not null
);

create table if not exists zt_trainrecords
(
    user       char(30)     not null,
    objectId   int unsigned not null,
    objectType varchar(10)  not null,
    status     varchar(10)  not null,
    primary key (user, objectId, objectType)
);

create table if not exists zt_trip
(
    id          int unsigned auto_increment
        primary key,
    type        enum ('trip', 'egress') default 'trip' not null,
    customers   varchar(20)                            not null,
    name        char(30)                               not null,
    `desc`      text                                   not null,
    year        char(4)                                not null,
    begin       date                                   not null,
    end         date                                   not null,
    start       time                                   not null,
    finish      time                                   not null,
    `from`      char(50)                               not null,
    `to`        char(50)                               not null,
    createdBy   char(30)                               not null,
    createdDate datetime                               not null
);

create index createdBy
    on zt_trip (createdBy);

create index year
    on zt_trip (year);

create table if not exists zt_user
(
    id           int unsigned auto_increment
        primary key,
    company      int unsigned                                                                        not null,
    type         char(30)                                              default 'inside'              not null,
    dept         int unsigned                                          default '0'                   not null,
    account      char(30)                                              default ''                    not null,
    password     char(32)                                              default ''                    not null,
    role         char(10)                                              default ''                    not null,
    realname     varchar(100)                                          default ''                    not null,
    pinyin       varchar(255)                                          default ''                    not null,
    nickname     char(60)                                              default ''                    not null,
    commiter     varchar(100)                                                                        not null,
    avatar       text                                                                                not null,
    birthday     date                                                  default '0000-00-00'          not null,
    gender       enum ('f', 'm')                                       default 'f'                   not null,
    email        char(90)                                              default ''                    not null,
    skype        char(90)                                              default ''                    not null,
    qq           char(20)                                              default ''                    not null,
    mobile       char(11)                                              default ''                    not null,
    phone        char(20)                                              default ''                    not null,
    weixin       varchar(90)                                           default ''                    not null,
    dingding     varchar(90)                                           default ''                    not null,
    slack        varchar(90)                                           default ''                    not null,
    whatsapp     varchar(90)                                           default ''                    not null,
    address      char(120)                                             default ''                    not null,
    zipcode      char(10)                                              default ''                    not null,
    nature       text                                                                                not null,
    analysis     text                                                                                not null,
    strategy     text                                                                                not null,
    `join`       date                                                  default '0000-00-00'          not null,
    visits       int unsigned                                          default '0'                   not null,
    visions      varchar(20)                                           default 'rnd,lite'            not null,
    ip           char(15)                                              default ''                    not null,
    last         int unsigned                                          default '0'                   not null,
    fails        int                                                   default 0                     not null,
    locked       datetime                                              default '0000-00-00 00:00:00' not null,
    feedback     enum ('0', '1')                                       default '0'                   not null,
    ranzhi       char(30)                                              default ''                    not null,
    ldap         char(30)                                                                            not null,
    score        int                                                   default 0                     not null,
    scoreLevel   int                                                   default 0                     not null,
    resetToken   varchar(50)                                                                         not null,
    deleted      enum ('0', '1')                                       default '0'                   not null,
    clientStatus enum ('online', 'away', 'busy', 'offline', 'meeting') default 'offline'             not null,
    clientLang   varchar(10)                                           default 'zh-cn'               not null,
    constraint account
        unique (account)
);

create index commiter
    on zt_user (commiter);

create index deleted
    on zt_user (deleted);

create index dept
    on zt_user (dept);

create index email
    on zt_user (email);

create table if not exists zt_usercontact
(
    id       int unsigned auto_increment
        primary key,
    account  char(30)    not null,
    listName varchar(60) not null,
    userList text        not null
);

create index account
    on zt_usercontact (account);

create table if not exists zt_usergroup
(
    account char(30)     default ''  not null,
    `group` int unsigned default '0' not null,
    project text                     not null,
    constraint account
        unique (account, `group`)
);

create table if not exists zt_userquery
(
    id       int unsigned auto_increment
        primary key,
    account  char(30)                    not null,
    module   varchar(30)                 not null,
    title    varchar(90)                 not null,
    form     text                        not null,
    `sql`    text                        not null,
    shortcut enum ('0', '1') default '0' not null,
    common   enum ('0', '1') default '0' not null
);

create index account
    on zt_userquery (account);

create index module
    on zt_userquery (module);

create table if not exists zt_usertpl
(
    id      int unsigned auto_increment
        primary key,
    account char(30)                    not null,
    type    char(30)                    not null,
    title   varchar(150)                not null,
    content text                        not null,
    public  enum ('0', '1') default '0' not null
);

create index account
    on zt_usertpl (account);

create table if not exists zt_userview
(
    account  char(30)   not null,
    programs mediumtext not null,
    products mediumtext not null,
    projects mediumtext not null,
    sprints  mediumtext not null,
    constraint account
        unique (account)
);

create table if not exists zt_vm
(
    id            int unsigned auto_increment
        primary key,
    hostID        int unsigned    default '0' not null,
    name          varchar(255)    default ''  not null,
    osCategory    varchar(50)     default ''  not null,
    osType        varchar(50)     default ''  not null,
    osArch        varchar(50)     default ''  not null,
    osLang        varchar(50)     default ''  not null,
    osCpu         int             default 0   not null,
    osMemory      int             default 0   not null,
    osDisk        int             default 0   not null,
    status        varchar(50)     default ''  not null,
    destroyAt     datetime                    null,
    macAddress    varchar(255)    default ''  not null,
    workspace     varchar(255)    default ''  not null,
    templateID    int unsigned    default '0' not null,
    baseImageID   int unsigned    default '0' not null,
    baseImagePath varchar(255)    default ''  not null,
    `desc`        varchar(255)    default ''  not null,
    heatbeat      datetime                    null,
    vncPort       int             default 0   not null,
    instance      varchar(255)    default ''  not null,
    eip           varchar(255)    default ''  not null,
    createdBy     varchar(30)                 not null,
    createdDate   datetime                    not null,
    editedBy      varchar(30)                 not null,
    editedDate    datetime                    not null,
    deleted       enum ('0', '1') default '0' not null,
    public        varchar(50)     default ''  not null
);

create table if not exists zt_vmtemplate
(
    id           int unsigned auto_increment
        primary key,
    name         varchar(255)             not null,
    hostID       int unsigned default '0' not null,
    templateName varchar(255) default ''  not null,
    osType       varchar(50)  default ''  not null,
    osCategory   varchar(50)  default ''  not null,
    osVersion    varchar(50)  default ''  not null,
    osLang       varchar(50)              not null,
    cpuCoreNum   int          default 0   not null,
    memorySize   int          default 0   not null,
    diskSize     int          default 0   not null,
    osArch       varchar(50)              not null
);

create table if not exists zt_webhook
(
    id          int unsigned auto_increment
        primary key,
    type        varchar(15)            default 'default'          not null,
    name        varchar(50)                                       not null,
    url         varchar(255)                                      not null,
    domain      varchar(255)                                      not null,
    secret      varchar(255)                                      not null,
    contentType varchar(30)            default 'application/json' not null,
    sendType    enum ('sync', 'async') default 'sync'             not null,
    products    text                                              not null,
    executions  text                                              not null,
    params      varchar(100)                                      not null,
    actions     text                                              not null,
    `desc`      text                                              not null,
    createdBy   varchar(30)                                       not null,
    createdDate datetime                                          not null,
    editedBy    varchar(30)                                       not null,
    editedDate  datetime                                          not null,
    deleted     enum ('0', '1')        default '0'                not null
);

create table if not exists zt_weeklyreport
(
    id        int unsigned auto_increment
        primary key,
    project   int unsigned not null,
    weekStart date         not null,
    pv        float(9, 2)  not null,
    ev        float(9, 2)  not null,
    ac        float(9, 2)  not null,
    sv        float(9, 2)  not null,
    cv        float(9, 2)  not null,
    staff     int unsigned not null,
    progress  varchar(255) not null,
    workload  varchar(255) not null,
    constraint week
        unique (project, weekStart)
);

create table if not exists zt_workestimation
(
    id             int unsigned auto_increment
        primary key,
    project        int unsigned                not null,
    scale          decimal(10, 2) unsigned     not null,
    productivity   decimal(10, 2) unsigned     not null,
    duration       decimal(10, 2) unsigned     not null,
    unitLaborCost  decimal(10, 2) unsigned     not null,
    totalLaborCost decimal(10, 2) unsigned     not null,
    createdBy      varchar(30)                 not null,
    createdDate    datetime                    not null,
    editedBy       varchar(30)                 not null,
    editedDate     datetime                    not null,
    assignedTo     varchar(30)                 not null,
    assignedDate   datetime                    not null,
    deleted        enum ('0', '1') default '0' not null,
    dayHour        decimal(10, 2)              null
);

create table if not exists zt_workflow
(
    id            int unsigned auto_increment
        primary key,
    parent        varchar(30)                                     not null,
    child         varchar(30)                                     not null,
    type          varchar(10)                  default 'flow'     not null,
    navigator     varchar(10)                                     not null,
    app           varchar(20)                                     not null,
    position      varchar(30)                                     not null,
    module        varchar(30)                                     not null,
    `table`       varchar(50)                                     not null,
    name          varchar(30)                                     not null,
    titleField    varchar(30)                                     not null,
    contentField  text                                            not null,
    flowchart     text                                            not null,
    js            text                                            not null,
    css           text                                            not null,
    `order`       int unsigned                                    not null,
    buildin       int unsigned                                    not null,
    administrator text                                            not null,
    `desc`        text                                            not null,
    version       varchar(10)                  default '1.0'      not null,
    status        varchar(10)                  default 'wait'     not null,
    vision        varchar(10)                  default 'rnd'      not null,
    approval      enum ('enabled', 'disabled') default 'disabled' not null,
    createdBy     varchar(30)                                     not null,
    createdDate   datetime                                        not null,
    editedBy      varchar(30)                                     not null,
    editedDate    datetime                                        not null,
    constraint `unique`
        unique (app, module, vision)
);

create index app
    on zt_workflow (app);

create index module
    on zt_workflow (module);

create index `order`
    on zt_workflow (`order`);

create index type
    on zt_workflow (type);

create table if not exists zt_workflowaction
(
    id            int unsigned auto_increment
        primary key,
    module        varchar(30)                                                              not null,
    action        varchar(50)                                                              not null,
    method        varchar(50)                                                              not null,
    name          varchar(50)                                                              not null,
    type          enum ('single', 'batch')                         default 'single'        not null,
    batchMode     enum ('same', 'different')                       default 'different'     not null,
    extensionType varchar(10)                                      default 'override'      not null comment 'none | extend | override',
    open          varchar(20)                                                              not null,
    position      enum ('menu', 'browseandview', 'browse', 'view') default 'browseandview' not null,
    layout        char(20)                                                                 not null,
    `show`        enum ('dropdownlist', 'direct')                  default 'dropdownlist'  not null,
    `order`       int unsigned                                                             not null,
    buildin       int unsigned                                                             not null,
    role          varchar(10)                                      default 'custom'        not null,
    `virtual`     int unsigned                                                             not null,
    conditions    text                                                                     not null,
    verifications text                                                                     not null,
    hooks         text                                                                     not null,
    linkages      text                                                                     not null,
    js            text                                                                     not null,
    css           text                                                                     not null,
    toList        char(255)                                                                not null,
    blocks        text                                                                     not null,
    `desc`        text                                                                     not null,
    status        varchar(10)                                      default 'enable'        not null,
    vision        varchar(10)                                      default 'rnd'           not null,
    createdBy     varchar(30)                                                              not null,
    createdDate   datetime                                                                 not null,
    editedBy      varchar(30)                                                              not null,
    editedDate    datetime                                                                 not null,
    constraint `unique`
        unique (module, action, vision)
);

create index action
    on zt_workflowaction (action);

create index module
    on zt_workflowaction (module);

create index `order`
    on zt_workflowaction (`order`);

create table if not exists zt_workflowdatasource
(
    id          int unsigned auto_increment
        primary key,
    type        enum ('system', 'sql', 'func', 'option', 'lang', 'category') default 'option' not null,
    name        varchar(30)                                                                   not null,
    code        varchar(30)                                                                   not null,
    datasource  text                                                                          not null,
    view        varchar(20)                                                                   not null,
    keyField    varchar(50)                                                                   not null,
    valueField  varchar(50)                                                                   not null,
    buildin     int unsigned                                                                  not null,
    vision      varchar(10)                                                  default 'rnd'    not null,
    createdBy   char(30)                                                                      not null,
    createdDate datetime                                                                      not null,
    editedBy    char(30)                                                                      not null,
    editedDate  datetime                                                                      not null
);

create index type
    on zt_workflowdatasource (type);

create table if not exists zt_workflowfield
(
    id          int unsigned auto_increment
        primary key,
    module      varchar(30)                       not null,
    field       varchar(50)                       not null,
    type        varchar(20)     default 'varchar' not null,
    length      varchar(10)                       not null,
    name        varchar(50)                       not null,
    control     varchar(20)                       not null,
    expression  text                              not null,
    options     text                              not null,
    `default`   varchar(100)                      not null,
    rules       varchar(255)                      not null,
    placeholder varchar(100)                      not null,
    `order`     int unsigned                      not null,
    searchOrder int unsigned    default '0'       not null,
    exportOrder int unsigned    default '0'       not null,
    canExport   enum ('0', '1') default '0'       not null,
    canSearch   enum ('0', '1') default '0'       not null,
    isValue     enum ('0', '1') default '0'       not null,
    readonly    enum ('0', '1') default '0'       not null,
    buildin     int unsigned                      not null,
    role        varchar(10)     default 'custom'  not null,
    `desc`      text                              not null,
    createdBy   varchar(30)                       not null,
    createdDate datetime                          not null,
    editedBy    varchar(30)                       not null,
    editedDate  datetime                          not null,
    constraint `unique`
        unique (module, field)
);

create index field
    on zt_workflowfield (field);

create index module
    on zt_workflowfield (module);

create index `order`
    on zt_workflowfield (`order`);

create table if not exists zt_workflowlabel
(
    id          int unsigned auto_increment
        primary key,
    module      varchar(30)                  not null,
    action      varchar(30) default 'browse' not null,
    code        varchar(30)                  not null,
    label       varchar(255)                 not null,
    params      text                         not null,
    orderBy     text                         not null,
    `order`     int                          not null,
    buildin     int unsigned                 not null,
    role        varchar(10) default 'custom' not null,
    createdBy   char(30)                     not null,
    createdDate datetime                     not null,
    editedBy    char(30)                     not null,
    editedDate  datetime                     not null
);

create index module
    on zt_workflowlabel (module);

create table if not exists zt_workflowlayout
(
    id           int unsigned auto_increment
        primary key,
    module       varchar(30)                   not null,
    action       varchar(50)                   not null,
    field        varchar(50)                   not null,
    `order`      int unsigned                  not null,
    width        int                           not null,
    position     text                          not null,
    readonly     enum ('0', '1') default '0'   not null,
    mobileShow   enum ('0', '1') default '1'   not null,
    summary      varchar(20)                   not null,
    defaultValue text                          not null,
    layoutRules  varchar(255)                  not null,
    vision       varchar(10)     default 'rnd' not null,
    constraint `unique`
        unique (module, action, field, vision)
);

create index action
    on zt_workflowlayout (action);

create index module
    on zt_workflowlayout (module);

create index `order`
    on zt_workflowlayout (`order`);

create table if not exists zt_workflowlinkdata
(
    objectType  varchar(30)  not null,
    objectID    int unsigned not null,
    linkedType  varchar(30)  not null,
    linkedID    int unsigned not null,
    createdBy   varchar(30)  not null,
    createdDate datetime     not null,
    constraint `unique`
        unique (objectType, objectID, linkedType, linkedID)
);

create table if not exists zt_workflowrelation
(
    id          int unsigned auto_increment
        primary key,
    prev        varchar(30)                 not null,
    next        varchar(30)                 not null,
    field       varchar(50)                 not null,
    actions     varchar(20)                 not null,
    actionCodes text                        not null,
    buildin     enum ('0', '1') default '0' not null,
    createdBy   char(30)                    not null,
    createdDate datetime                    not null
);

create table if not exists zt_workflowrelationlayout
(
    id      int unsigned auto_increment
        primary key,
    prev    varchar(30)  not null,
    next    varchar(30)  not null,
    action  varchar(50)  not null,
    field   varchar(50)  not null,
    `order` int unsigned not null,
    constraint `unique`
        unique (prev, next, action, field)
);

create index action
    on zt_workflowrelationlayout (action);

create index next
    on zt_workflowrelationlayout (next);

create index `order`
    on zt_workflowrelationlayout (`order`);

create index prev
    on zt_workflowrelationlayout (prev);

create table if not exists zt_workflowreport
(
    id          int unsigned auto_increment
        primary key,
    module      varchar(30)                                 not null comment 'module name',
    name        varchar(100)                                not null comment 'report name',
    type        enum ('pie', 'line', 'bar') default 'pie'   not null comment 'report type',
    countType   enum ('sum', 'count')       default 'sum'   not null comment 'report count method',
    displayType enum ('value', 'percent')   default 'value' not null comment 'report display method',
    dimension   varchar(130)                                not null comment 'dimension field code of zt_workflowfield',
    fields      text                                        not null comment 'count fileds code of zt_workflowfield,use comma split',
    `order`     int unsigned                default '0'     not null,
    createdBy   varchar(30)                                 not null,
    createdDate datetime                                    not null
);

create table if not exists zt_workflowrule
(
    id          int unsigned auto_increment
        primary key,
    type        enum ('system', 'regex', 'func') default 'regex' not null,
    name        varchar(30)                                      not null,
    rule        text                                             not null,
    createdBy   char(30)                                         not null,
    createdDate datetime                                         not null,
    editedBy    char(30)                                         not null,
    editedDate  datetime                                         not null
);

create index type
    on zt_workflowrule (type);

create table if not exists zt_workflowsql
(
    id          int unsigned auto_increment
        primary key,
    module      varchar(30) not null,
    field       varchar(50) not null,
    action      varchar(50) not null,
    `sql`       text        not null,
    vars        text        not null,
    createdBy   varchar(30) not null,
    createdDate datetime    not null,
    editedBy    varchar(30) not null,
    editedDate  datetime    not null
);

create index action
    on zt_workflowsql (action);

create index field
    on zt_workflowsql (field);

create index module
    on zt_workflowsql (module);

create table if not exists zt_workflowversion
(
    id      int unsigned auto_increment
        primary key,
    module  varchar(30) not null,
    version varchar(10) not null,
    fields  text        not null,
    actions text        not null,
    layouts text        not null,
    sqls    text        not null,
    labels  text        not null,
    `table` text        not null,
    datas   text        not null,
    constraint moduleversion
        unique (module, version)
);

create index module
    on zt_workflowversion (module);

create index version
    on zt_workflowversion (version);

create table if not exists zt_zoutput
(
    id          int unsigned auto_increment
        primary key,
    activity    int                         not null,
    name        varchar(255)                not null,
    content     mediumtext                  not null,
    optional    char(20)                    not null,
    tailorNorm  varchar(255)                not null,
    status      varchar(30)                 not null,
    createdBy   varchar(30)                 not null,
    createdDate datetime                    not null,
    editedBy    varchar(30)                 not null,
    editedDate  datetime                    not null,
    `order`     int             default 0   null,
    deleted     enum ('0', '1') default '0' not null
);

