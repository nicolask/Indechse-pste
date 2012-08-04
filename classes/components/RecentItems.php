<?php
require_once 'Pste/View.php';

class RecentItems extends Pste_View {
    protected function _init() {
        $this->setTemplate('components/recent_items.php');
        $this->getRecentItems();
    }
    
    public function getRecentItems() {
        
        $config = Pste_Registry::getInstance()->config;
        
        $db = new DB();
        
        // Get raw db info.
        $posts = $db->getRecentPostSummary($config->list);

        // Augment with some formatting
        foreach ($posts as $idx => $post) {
            $age = $post['age'];
            $days = floor($age / (3600 * 24));
            $hours = floor($age / 3600);
            $minutes = floor($age / 60);
            $seconds = $age;

            if ($days > 1)
                $age = "$days days ago";
            elseif ($hours > 0)
                $age = "$hours hour" . (($hours > 1) ? "s" : "") . " ago";
            elseif ($minutes > 0)
                $age = "$minutes minute" . (($minutes > 1) ? "s" : "") . " ago";
            else
                $age = "< 1 min ago";

            
            $posts[$idx]['agefmt'] = $age;
            $posts[$idx]['url'] = $config->url.$post['pid'];
        }

        $this->recent = $posts;
    }
}