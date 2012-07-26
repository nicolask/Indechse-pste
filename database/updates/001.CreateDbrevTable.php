<?php

class Update_CreateDbrevTable extends Maintain_Update_Abstract implements Maintain_Update_Interface
{

    public function update()
    {
        $sql = '
            CREATE TABLE "dbrev" (
                "id" serial NOT NULL,
                "revision" varchar(32) NOT NULL,
                "updated" timestamp NOT NULL DEFAULT NOW(),
                "updatename" VARCHAR(100) NOT NULL,
                PRIMARY KEY ("id"),
                UNIQUE ("revision", "updatename")
            );
        ';
        return $this->_getDbCOnn()->exec($sql);
    }

}
