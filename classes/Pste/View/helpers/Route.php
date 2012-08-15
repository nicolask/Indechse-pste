<?php
/**
 * View-Helper to create internal urls in templates
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
class Pste_View_Helper_Route
{
    /**
     *
     * @return \Pste_Route 
     */
    public function route() {
        $route = Pste_Registry::getInstance()->route;
        if (!($route instanceof Pste_Route)) {
            $route = new Pste_Route();
            $route->setTemplatePath(Pste_Registry::getInstance()->config->template);
            Pste_Registry::getInstance()->route = $route;
            
        }
        
        return $route;
    }
}
