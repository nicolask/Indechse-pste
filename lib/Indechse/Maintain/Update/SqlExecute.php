<?php
class Indechse_Maintain_Update_SqlExecute extends Indechse_Maintain_Update_Abstract {
    
    private $statements;
    
    public function setSql($sql) {
        $this->statements = $sql;
    }
    
    public function update()
    {
        if (null === $this->statements) {
            throw new Exception('You must provide an sql statement before calling update()!');
        }
        
        $this->_getDbCOnn()->exec($this->statements);
    }
}
