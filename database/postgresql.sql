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
)
