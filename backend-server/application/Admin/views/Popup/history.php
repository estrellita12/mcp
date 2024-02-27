<section class="contents">
    <h1 class="cont_title">변경 기록</h1>
    <div class="cont_wrap">
        <div class="list_wrap">
            <div class="chead02_wrap">
                <table>
                    <tbody>
                    <?php $i=0; foreach( $this->row as $row) { ?>
                    <tr class="list<?=$i%2?>">
                    <?php foreach( $row as $key=>$value) { 
                        if( strpos($key,"change_data") ){
                            $value = json_decode($value,true);      
                            echo "<td style='width:200px;padding:2px;font-size:12px; text-align:left'>";
                            foreach($value as $col){
                                echo "<span title='{$col['pre_value']}\n(▼)\n{$col['change_value']}'>[({$col['col_name']}) {$col['comment']}]</span><br>";
                            }
                            echo "</td>";
                        }else{
                            echo "<td style='width:80px;padding:2px;font-size:12px'>{$value}</td>";
                        }
                    ?>
                    <?php  } ?>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

