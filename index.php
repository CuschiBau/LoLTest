<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="static/css/bootstrap.css">
        <link rel="stylesheet" href="static/css/main.css?a=1">
    <body>
        <div class="content-flex">
            <div class="row">
                <div class="col-4">
        <?php
            include('functions/globals.php');
            $config = include('config/config.php'); 

            $resp = callAPI('euw1','static-data/v3','champions',array('champListData'=>'all'),$config);
            $items = callAPI('eun1','static-data/v3','items',array('itemListData'=>'all'),$config);

            echo '<div class="box"><span class="pr-4"><select id="champSelect" class="custom-select">';
            foreach($resp as $champ){
                echo '<option value="'.$champ->id.'">'.$champ->name.'</option>';
            }            
            echo '</select></span><select id="champLvlSelect" class="custom-select">';
            for ($i=1; $i < 19 ; $i++) {
                echo '<option value="cL'.$i.'">'.$i.'</option>';
            }
            echo '</select></div>';

            foreach($resp as $champ){
        ?>
                <div id="<?=$champ->id?>" class="champBlock">
                    <div class>
                        <img src="http://ddragon.leagueoflegends.com/cdn/6.24.1/img/champion/<?=$champ->image->full?>" alt="">
                        <span class="champName"><?=$champ->name?></span>
                    </div>
                    <div class="mt-5">
                        <?php
                            foreach($champ->stats as $statName => $stat){
                                ${$statName} = $stat;
                            }

                            for ($i=1; $i < 19 ; $i++) { 
                                $cAD = calcStatsGrowth($attackdamage,$attackdamageperlevel,$i);
                                $cHP = calcStatsGrowth($hp,$hpperlevel,$i);
                                $cHPRegen = calcStatsGrowth($hpregen,$hpregenperlevel,$i);
                                $cMP = calcStatsGrowth($mp,$mpperlevel,$i);
                                $cMPRegen = calcStatsGrowth($mpregen,$mpregenperlevel,$i);
                                $baseAttackSpeed = round( 0.625 / (1+$attackspeedoffset), 3);
                                $cAttackSpeed = calcStatsGrowth($baseAttackSpeed,($attackspeedperlevel/100),$i); ;
                                $cArmor = calcStatsGrowth($armor,$armorperlevel,$i);
                                $cMR = calcStatsGrowth($spellblock,$spellblockperlevel,$i);
                        ?>
                                <div class="champLvl" id="cL<?=$i.$champ->id?>">
                                    <div class="mb-2">Base Stats per Level <span class="badge badge-secondary"><?=$i?></span></div>

                                    <div class="attr">AD: <span data-attr="ad" data-base="<?=$cAD?>"> <?=$cAD?> </span></div>
                                    <div class="attr">AP: <span data-attr="ap" data-base="0">0</span></div>
                                    <div class="attr">HP: <span data-attr="hp" data-base="<?=$cHP?>"><?=$cHP?></span></div>
                                    <div class="attr">HP Regen: <span data-attr="hpr" data-base="<?=$cHPRegen?>"><?=$cHPRegen?></span></div>
                                    <div class="attr">Mana: <span data-attr="mp" data-base="<?=$cMP?>"><?=$cMP?></span></div>
                                    <div class="attr">Mana Regen: <span  data-attr="mpr" data-base="<?=$cMPRegen?>"><?=$cMPRegen?></span></div>
                                    <div class="attr">Attack Speed: <span  data-attr="crit" data-base="<?=$cAttackSpeed?>"><?=$cAttackSpeed?></span></div>
                                    <div class="attr">Crit Chance: <span  data-attr="crit" data-base="0">0</span></div>
                                    <div class="attr">Armor: <span data-attr="ar" data-base="<?=$cArmor?>"><?=$cArmor?></span></div>
                                    <div class="attr">Magic Resist: <span data-attr="mr" data-base="<?=$cMR?>"><?=$cMR?></span></div>
                                    <div class="attr">Movement Speed: <span data-attr="ms" data-base="<?=$movespeed?>"><?=$movespeed?></span></div>
                                </div>
                        <?php
                            }
                            
                        ?>                        
                    </div>
                    <hr/>
                </div>                
        <?php
            }
        ?>
            </div>
                <div class="col-8">
                
                    <div id="div1" style="margin-top:200px;width:200px;height:200px;border:1px solid black;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                
                </div>
            </div>
        </div>
        <?php

            foreach($items as $item){
                $twistedT = '10';
                $summonersR = '11';
                $HowlingA = '12';
                if(($item->maps->$twistedT || $item->maps->$summonersR || $item->maps->$HowlingA) && !property_exists($item,'hideFromAll') ){ 
                ?>
                    <div class="itemBlock">
                        <div><span class="pr-2"><input type="checkbox" value="<?=$item->id?>"/></span><?=$item->name?> - <?=$item->id?></div>
                        <img src="http://ddragon.leagueoflegends.com/cdn/6.24.1/img/item/<?=$item->image->full?>" alt="" draggable="true" ondragstart="drag(event)">
                        <div>
                            <?php
                                /*if(property_exists($item,'stats')){
                                    foreach($item->stats as $mod=>$val){
                                        ?>                                    
                                        <div class="statMods" data-mod="<?=$mod.'|'.$val?>"><?=$mod.'|'.$val?></div>
                                        <?php
                                    }
                                }*/
                            ?>
                        </div>
                        <hr/>
                    </div>
                <?php
                 }
            }

        ?>

        <div id="js_container">
            <script type="text/javascript" src="static/js/jquery-3.2.1.js"></script>
            <script type="text/javascript" src="static/js/main.js?a=4"></script>
        </div>

    </body>
</html>