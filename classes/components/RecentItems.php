<?php
/**
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

namespace Pste\Component;

class RecentItems extends \Pste\View {
    protected function _init() {
        $this->setTemplate('components/recent_items.php');
        $this->getRecentItems();
    }
    
    public function getRecentItems() {
        
        $config = \Pste\Registry::getInstance()->config;
        
        $db = new \DB();
        
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