

<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				
                
                <?php
                $url_class = $this->router->fetch_class();
                $url_method = $this->router->fetch_method();
                $segs = $this->uri->segment_array();
                $url_method_arr = array(
                    $url_method,
                    $url_method."/".end($segs)
                );
                $list_menu = $this->far_menu->list_menu_by_group($this->flexi_auth->get_user_group_id());
                $count_menu = count($list_menu);
                $last_menu = $count_menu-1;
                
                //echo '<pre>'; print_r($list_menu); echo '</pre>';
                
                foreach($list_menu as $keymenu => $keyvalue){ 
                    
                    $menuactive = array(); $menuopen = array();
                ?>
                    
                    <?php if($keyvalue['link'] == 'ci_controller'){ $menu_link = base_url().$keyvalue['controller'].'/'.$keyvalue['method']; } ?>
                    
                    <?php
                    if(is_array($keyvalue['children'])){ 
                        foreach($keyvalue['children'] as $k => $v){
                            
                            if(($url_class == $v['controller']) && (in_array($v['method'], $url_method_arr))){
                                $menuactive[] = 'active'; $menuopen[] = 'open';
                            }else{
                                $menuactive[] = ''; $menuopen[] = '';
                            }
                            
                            if(is_array($v['children'])){
                                foreach($v['children'] as $k2 => $v2){
                                    if(($url_class == $v2['controller']) && (in_array($v['method'], $url_method_arr))){
                                        $menuactive[] = 'active'; $menuopen[] = 'open';
                                    }else{
                                        $menuactive[] = ''; $menuopen[] = '';
                                    }
                                }
                            }
                        }
                        
                        
                    ?>
                    
                    <?php if($keyvalue['visible'] == '1'){ ?> 
                    
                    <li class="left_menu_li <?php if($keymenu == 0){ echo 'start'; } if($last_menu == $keymenu){ echo 'last'; } ?> 
                    <?php if(in_array('active', $menuactive)){ echo 'active'; }; ?> 
                    <?php if(in_array('open', $menuopen)){ echo 'open'; }; ?>">
    					<a href="<?php echo base_url().$keyvalue['controller'].'/'.$keyvalue['method']; ?>">
    					<i class="<?php echo $keyvalue['icon-class']; ?>"></i>
    					<span class="title" data-flags="<?php echo $keyvalue['flags'] ?>"><?php echo $keyvalue['name']; ?></span>
    					<span class="selected"></span>
    					<span class="<?php if(is_array($keyvalue['children'])){ echo 'arrow'; } ?> 
                        <?php if(in_array('open', $menuopen)){ echo 'open'; }; ?>
                        "></span>
    					</a>
  
                        
                        <?php if(is_array($keyvalue['children'])){ ?>
    					<ul class="sub-menu">
                        <?php
                        foreach($keyvalue['children'] as $key2 => $value2){
                            
                            if($value2['link'] == 'ci_controller'){ $menu_link2 = base_url().$value2['controller'].'/'.$value2['method']; }
                            
                            if(($url_class == $value2['controller']) && (in_array($value2['method'], $url_method_arr))){ 
                                $menuactive2[] = 'active'; 
                                $menuopen2[] = 'open';
                            }else{
                                $menuactive2[] = ''; 
                                $menuopen2[] = '';
                            }
                        
                        ?>
                            <?php if($value2['visible'] == '1'){ ?> 
    						<li class="<?php echo $menuactive2[$key2]; ?>">
    							<a href="<?php echo $menu_link2; ?>">
    							<i class="<?php echo $value2['icon-class']; ?>"></i>
                                <?php if(is_array($value2['children'])){ ?>
                                <span class="arrow"></span>
                                <?php } ?>
    							<?php echo $value2['name']; ?></a>
                                
                                    <!-- Third menu -->
                                    <?php if(is_array($value2['children'])){ ?>
                					<ul class="sub-menu">
                                    <?php
                                    foreach($value2['children'] as $key3 => $value3){
                                        
                                        if($value3['link'] == 'ci_controller'){ $menu_link3 = base_url().$value3['controller'].'/'.$value3['method']; }
                                        
                                        if(($url_class == $value3['controller']) && (in_array($value3['method'], $url_method_arr))){ 
                                            $menuactive3[] = 'active'; 
                                            $menuopen3[] = 'open';
                                        }else{
                                            $menuactive3[] = ''; 
                                            $menuopen3[] = '';
                                        }
                                    
                                    ?>
                                        <?php if($value3['visible'] == '1'){ ?> 
                						<li class="<?php echo $menuactive3[$key3]; ?>">
                							<a href="<?php echo $menu_link3; ?>">
                							<i class="<?php echo $value3['icon-class']; ?>"></i>
                							<?php echo $value3['name']; ?></a>
                						</li>
                                        <?php } ?>
                					
                                    
                                    <?php } $menuactive3 = array();
                                    ?>
                                    
                                    </ul>
                                    <?php } ?>
    						</li>
                            <?php } ?>
    					
                        
                        <?php } $menuactive2 = array();
                        ?>
                        
                        </ul>
                        <?php } ?>
    				</li>
                    <?php } ?>
                    <?php }else{ ?>
                        <?php if($keyvalue['visible'] == "1"){ ?> 
                        
                            <?php
                            //is menu active
                            $is_menu_active = "";
                            if(($url_class == $keyvalue['controller']) && ($url_method == $keyvalue['method'])){
                                $is_menu_active = "active";
                            }
                            ?>
                        
                            <li class="left_menu_li <?php if($keymenu == 0){ echo 'start'; } if($last_menu == $keymenu){ echo 'last'; } ?> <?php echo $is_menu_active; ?>"> 
                            <a href="<?php echo base_url().$keyvalue['controller'].'/'.$keyvalue['method']; ?>">
        					<i class="<?php echo $keyvalue['icon-class']; ?>"></i>
        					<span class="title"><?php echo $keyvalue['name']; ?></span>
        					<span class="selected"></span>
        					<span class="<?php if(is_array($keyvalue['children'])){ echo 'arrow'; } ?> 
                            <?php if(in_array('open', $menuopen)){ echo 'open'; }; ?>
                            "></span>
        					</a>
                            </li>
                        
                        <?php } ?>
                        
                        
                        
                    <?php } ?>
                <?php } ?>
                
				
				
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>