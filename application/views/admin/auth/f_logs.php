<?php
foreach($items as $item){
    ?>
   <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div class="">
                            <h6 class="mb-0 text-sm"><?=$fn->format($item->created_at)?></h6>
                          </div>
                        </div>
                      </td>
                      <td class="text-wrap">
                        <p class="text-sm"><?=$item->activity?></p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold"><p class="text-sm"><?=str_replace('"','',$item->device)?></p></span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold"><?=$item->ipaddress?></span>
                        
                          </div>
                        </div>
                      </td>
                    
                    </tr>
                 
    <?php
}
?>