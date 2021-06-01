<?php

?>
<html>
    <head>
        <link rel="stylesheet" href="./style.css">
        <script src="./script.js"></script>
    </head>
    <body onload="populatePage()">
        <div id="generateColumns">
            <div>
                <div>
                    <label for="idEvent"> Id-ul evenimentului </label>
                    <input readonly id="idEvent" name="eventid" value=""/>
                </div>
                <div>
                    <label for="day">Zi </label>
                    <input id="day" name="iday" placeholder=""/>
                </div>
                <div>
                <label for="month"> Luna </label>
                    <input id="month" name="imonth" placeholder=""/>
                </div>
                <div>
                    <label for="year">An </label>
                    <input id="year" name="iyear" placeholder=""/>    
                </div>      
                <div>
                    <label for="latitude"> Latitudine </label>
                    <input id="latitude" name="latitude" placeholder=""/>    
                </div>         
                <div>
                    <label for="longitude"> Longitudine </label>
                    <input id="longitude" name="longitude" placeholder=""/>    
                </div>         
            </div>

            <div>
                <label for="city"> Oras </label>
                <input id="city" name="city" placeholder=""/>
                <label for="country"> Tara </label>
                <input id="country" name="country_txt" placeholder=""/>
                <label for="region"> Regiune </label>
                <input id="region" name="region_txt" placeholder=""/>
                <label for="suicide"> Suicid </label>
                <select name="suicide">
                    <option value="1" selected> Da </option>
                    <option value="0"> Nu </option>
                </select>
                <label for="extended"> Extins pe mai mult de 24h? </label>
                <select name="extended">
                    <option value="1" selected> Da </option>
                    <option value="0"> Nu </option>
                </select>
                <label for="eventType">Tipul eveniment </label>
                <input id="eventType" name="attacktype1_txt" placeholder=""/>
                <label for="eventTarget">Tinta eveniment </label>
                <input id="eventTarget" name="targsubtype1_txt" placeholder=""/>
                <label for="success">A avut succes? </label>
                <select name="success">
                    <option value="1" selected> Da </option>
                    <option value="0"> Nu</option>
                </select>
                <label for="weaponType"> Tipul armei </label>
                <input id="weaponType" name="weaptype1_txt" placeholder="" />
                
                <div> <button type="submit" value="Update" onclick="updateDataInDb()">Update</button> </div>
            
            </div>

            <div>

                <label for="killedno"> Numarul persoanelor ucise </label>
                <input type="number" name="nkill" id="killedno" placeholder=""/>
                
                <label for="injuredno">Numarul persoanelor ranite </label>
                <input type="number" name="nwound" id="injuredno" placeholder=""/>
                <label for="nameterro"> Numele grupului terorist </label>
                <input id="nameterro" name="gname" placeholder=""/>
                <label for="reason"> Motivul </label>
                <input id="reason" name="motive" placeholder=""/>
                <label for="terrono">Numarul total de teroristi implicati </label>
                <input id="terrono" name="nperps" placeholder=""/>
            </div>
            
                
            </div>
    </body>
</html>