$(document).ready(function () { 

    $('.champBlock').eq(0).css('display','block')
    $('.champLvl').eq(0).css('display','block')
    
    $(document).on('change','#champSelect',function(){
        $('.champBlock').each(function(){ $(this).css('display','none') })
        $('#'+$(this).val()).css('display','block')
        $('#'+$(this).val()).find('.champLvl').eq(0).css('display','block')
    })

    $(document).on('change','#champLvlSelect',function(){
        $('.champLvl').each(function(){ $(this).css('display','none') })
        let lvl = $(this).val()
        $('.champBlock').each(function(){
            if($(this).css('display') == 'block'){ $('#'+lvl+$(this).attr('id')).css('display','block') }
        })
    })

    $(document).on('change','.itemBlock input[type="checkbox"]',function(){
        //let modsArray = []
        let that = $(this)
        $(this).closest('.itemBlock').find('.statMods').each(function(){
            
            let dataMods = $(this).data("mod").split('|');
            let modsObj = {[dataMods[0]] : dataMods[1]}
            //modsArray.push(modsObj)
            var attr = '', k = ''
            switch (dataMods[0]) {
                case "FlatPhysicalDamageMod": attr = 'ad'; break;
                case "FlatMagicDamageMod": attr = 'ap'; break;
                case "FlatHPPoolMod": attr = 'hp'; break;
                case "FlatHPRegenMod": attr = 'hpr'; break;
                case "FlatMPPoolMod": attr = 'mp'; break;
                case "FlatMPRegenMod": attr = 'mpr'; break;
                case "FlatCritChanceMod": attr = 'crit'; break;
                case "FlatArmorMod": attr = 'ar'; break;
                case "FlatSpellBlockMod": attr = 'mr'; break;
                case "PercentMovementSpeedMod": attr = 'ms'; k = 'p' ; break;
                default: attr = undefined; break;
            }
            $('.attr [data-attr="'+ attr +'"]').each(function(){
                if(k == 'p'){
                    if(that.get(0).checked) $(this).text(parseFloat($(this).text())+(parseFloat($(this).text())*parseFloat(dataMods[1])))
                    else $(this).text((parseFloat($(this).text())/(1+parseFloat(dataMods[1]))))
                }else{
                    if(that.get(0).checked) $(this).text(parseFloat($(this).text())+parseFloat(dataMods[1]))
                    else $(this).text(parseFloat($(this).text())-parseFloat(dataMods[1]))
                }
            })
        })

    })

    

})

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var obj = document.createElement('img')
    $(obj).attr('src',data)
    ev.target.append(obj);
}