<html>
    <head></head>
    <body>
        <?php
            include('functions/globals.php');
            $config = include('config/config.php'); 

            $resp = callAPI('euw1','static-data/v3','champions',array('champListData'=>'all'),$config);
        
            foreach($resp as $champ){
        ?>
                <div>
                    <div><?=$champ->name?></div>
                    <div>
                        <?php
                            foreach($champ->stats as $statName => $stat){
                                ${$statName} = $stat;
                            }
                        ?>
                            <div>Base Stats per Level</div>
                        <?php
                            for ($i=1; $i < 19 ; $i++) { 
                                $cAD = calcStatsGrowth($attackdamage,$attackdamageperlevel,$i);
                                $cHP = calcStatsGrowth($hp,$hpperlevel,$i);
                                $cHPRegen = calcStatsGrowth($hpregen,$hpregenperlevel,$i);
                                $cMP = calcStatsGrowth($mp,$mpperlevel,$i);
                                $cMPRegen = calcStatsGrowth($mpregen,$mpregenperlevel,$i);
                                $cArmor = calcStatsGrowth($armor,$armorperlevel,$i);
                                $cMR = calcStatsGrowth($spellblock,$spellblockperlevel,$i);
                        ?>
                                <div><?=$i?> - AD: <?=$cAD?></div>
                                <div><?=$i?> - HP: <?=$cHP?></div>
                                <div><?=$i?> - HP Regen: <?=$cHPRegen?></div>
                                <div><?=$i?> - Mana: <?=$cMP?></div>
                                <div><?=$i?> - Mana Regen: <?=$cMPRegen?></div>
                                <div><?=$i?> - Armor: <?=$cArmor?></div>
                                <div><?=$i?> - Magic Resist: <?=$cMR?></div>
                                <hr/>
                        <?php
                            }
                            
                        ?>                        
                    </div>
                </div>
                <hr/>
        <?php
            }

        ?>
    </body>
</html>