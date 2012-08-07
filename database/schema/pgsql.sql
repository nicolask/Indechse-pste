CREATE TABLE "paste" (
    "pid" serial NOT NULL,
    "poster" varchar(16) default NULL,
    "posted" timestamp default NULL,
    "code" text,
    "parent_pid" integer default '0',
    "format" varchar(16) default NULL,
    "codefmt" text,
    "expiry_flag" char NOT NULL, CHECK ("expiry_flag" IN ('d','m','f')), 
    "codecss" text,
    "expires" timestamp default NULL,
    "password" varchar(250) default NULL,
    PRIMARY KEY  ("pid")
);

CREATE TABLE "dbrev" (
    "id" serial NOT NULL,
    "revision" varchar(32) NOT NULL,
    "updated" timestamp NOT NULL DEFAULT NOW(),
    "updatename" VARCHAR(100) NOT NULL,
    PRIMARY KEY ("id"),
    UNIQUE ("revision", "updatename")
);

CREATE TABLE "user" (
    "id" serial NOT NULL,
    "username" VARCHAR(40) NOT NULL,
    "password" VARCHAR(40) NOT NULL,
    "active" BOOLEAN NOT NULL DEFAULT true,
    PRIMARY KEY ("id")
);

CREATE TABLE "group" (
    "id" serial NOT NULL,
    "groupname" VARCHAR(40) NOT NULL,
    "parent_group" INTEGER REFERENCES "group"("id") ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY ("id")
);

CREATE TABLE "membership" (
    "id" serial NOT NULL,
    "group_id" INTEGER REFERENCES "group"("id") ON DELETE CASCADE ON UPDATE CASCADE,
    "user_id" INTEGER REFERENCES "user"("id") ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY("id"),
    UNIQUE("group_id", "user_id")
);