@props(['value' => '-- is empty --'])

<select {{ $attributes->merge(['class' => 'input block']) }}>
    <option value="-- is empty --">-- is empty --</option>
    <option {{ $value == "AF Afghanistan" ? 'selected' : '' }} value="AF Afghanistan">AF Afghanistan</option>
    <option {{ $value == "AL Albania" ? 'selected' : '' }} value="AL Albania">AL Albania</option>
    <option {{ $value == "AM Armenia" ? 'selected' : '' }} value="AM Armenia">AM Armenia</option>
    <option {{ $value == "AT Austria" ? 'selected' : '' }} value="AT Austria">AT Austria</option>
    <option {{ $value == "AZ Azerbaijan" ? 'selected' : '' }} value="AZ Azerbaijan">AZ Azerbaijan</option>
    <option {{ $value == "BA Bosnia-Herzegovina" ? 'selected' : '' }} value="BA Bosnia-Herzegovina">BA Bosnia-Herzegovina</option>
    <option {{ $value == "BE Belgium" ? 'selected' : '' }} value="BE Belgium">BE Belgium</option>
    <option {{ $value == "BG Bulgaria" ? 'selected' : '' }} value="BG Bulgaria">BG Bulgaria</option>
    <option {{ $value == "BH Bahrain" ? 'selected' : '' }} value="BH Bahrain">BH Bahrain</option>
    <option {{ $value == "BY Belarus" ? 'selected' : '' }} value="BY Belarus">BY Belarus</option>
    <option {{ $value == "CH Switzerland" ? 'selected' : '' }} value="CH Switzerland">CH Switzerland</option>
    <option {{ $value == "CN China" ? 'selected' : '' }} value="CN China">CN China</option>
    <option {{ $value == "CY Cyprus" ? 'selected' : '' }} value="CY Cyprus">CY Cyprus</option>
    <option {{ $value == "CZ Czech Republic" ? 'selected' : '' }} value="CZ Czech Republic">CZ Czech Republic</option>
    <option {{ $value == "DE Germany" ? 'selected' : '' }} value="DE Germany">DE Germany</option>
    <option {{ $value == "DK Denmark" ? 'selected' : '' }} value="DK Denmark">DK Denmark</option>
    <option {{ $value == "DZ Algeria" ? 'selected' : '' }} value="DZ Algeria">DZ Algeria</option>
    <option {{ $value == "EE Estonia" ? 'selected' : '' }} value="EE Estonia">EE Estonia</option>
    <option {{ $value == "EG Egyp" ? 'selected' : '' }} value="EG Egyp">EG Egyp</option>
    <option {{ $value == "ER Eritrea" ? 'selected' : '' }} value="ER Eritrea">ER Eritrea</option>
    <option {{ $value == "ES Spain" ? 'selected' : '' }} value="ES Spain">ES Spain</option>
    <option {{ $value == "ET Ethiopia" ? 'selected' : '' }} value="ET Ethiopia">ET Ethiopia</option>
    <option {{ $value == "FI Finland" ? 'selected' : '' }} value="FI Finland">FI Finland</option>
    <option {{ $value == "FO Faroe Islands" ? 'selected' : '' }} value="FO Faroe Islands">FO Faroe Islands</option>
    <option {{ $value == "FR France" ? 'selected' : '' }} value="FR France">FR France</option>
    <option {{ $value == "GB United Kingdom" ? 'selected' : '' }} value="GB United Kingdom">GB United Kingdom</option>
    <option {{ $value == "GE Georgia" ? 'selected' : '' }} value="GE Georgia">GE Georgia</option>
    <option {{ $value == "GI Gibraltar" ? 'selected' : '' }} value="GI Gibraltar">GI Gibraltar</option>
    <option {{ $value == "GR Greece" ? 'selected' : '' }} value="GR Greece">GR Greece</option>
    <option {{ $value == "HR Croatia" ? 'selected' : '' }} value="HR Croatia">HR Croatia</option>
    <option {{ $value == "HU Hungary" ? 'selected' : '' }} value="HU Hungary">HU Hungary</option>
    <option {{ $value == "IE Ireland" ? 'selected' : '' }} value="IE Ireland">IE Ireland</option>
    <option {{ $value == "IL Israel" ? 'selected' : '' }} value="IL Israel">IL Israel</option>
    <option {{ $value == "IN India" ? 'selected' : '' }} value="IN India">IN India</option>
    <option {{ $value == "IQ Iraq" ? 'selected' : '' }} value="IQ Iraq">IQ Iraq</option>
    <option {{ $value == "IR Iran" ? 'selected' : '' }} value="IR Iran">IR Iran</option>
    <option {{ $value == "IS Iceland" ? 'selected' : '' }} value="IS Iceland">IS Iceland</option>
    <option {{ $value == "IT Italy" ? 'selected' : '' }} value="IT Italy">IT Italy</option>
    <option {{ $value == "JO Jordan" ? 'selected' : '' }} value="JO Jordan">JO Jordan</option>
    <option {{ $value == "KG Kyrgyzstan" ? 'selected' : '' }} value="KG Kyrgyzstan">KG Kyrgyzstan</option>
    <option {{ $value == "KW Kuwait" ? 'selected' : '' }} value="KW Kuwait">KW Kuwait</option>
    <option {{ $value == "KZ Kazakhstan" ? 'selected' : '' }} value="KZ Kazakhstan">KZ Kazakhstan</option>
    <option {{ $value == "LB Lebanon" ? 'selected' : '' }} value="LB Lebanon">LB Lebanon</option>
    <option {{ $value == "LI Liechtenstein" ? 'selected' : '' }} value="LI Liechtenstein">LI Liechtenstein</option>
    <option {{ $value == "LT Lithuania" ? 'selected' : '' }} value="LT Lithuania">LT Lithuania</option>
    <option {{ $value == "LU Luxembourg" ? 'selected' : '' }} value="LU Luxembourg">LU Luxembourg</option>
    <option {{ $value == "LV Latvia" ? 'selected' : '' }} value="LV Latvia">LV Latvia</option>
    <option {{ $value == "LY Libya" ? 'selected' : '' }} value="LY Libya">LY Libya</option>
    <option {{ $value == "MA Morocco" ? 'selected' : '' }} value="MA Morocco">MA Morocco</option>
    <option {{ $value == "MC Monaco" ? 'selected' : '' }} value="MC Monaco">MC Monaco</option>
    <option {{ $value == "MD Moldavia" ? 'selected' : '' }} value="MD Moldavia">MD Moldavia</option>
    <option {{ $value == "ME Montenegro" ? 'selected' : '' }} value="ME Montenegro">ME Montenegro</option>
    <option {{ $value == "MK Macedonia" ? 'selected' : '' }} value="MK Macedonia">MK Macedonia</option>
    <option {{ $value == "MN Mongolia" ? 'selected' : '' }} value="MN Mongolia">MN Mongolia</option>
    <option {{ $value == "MT Malta" ? 'selected' : '' }} value="MT Malta">MT Malta</option>
    <option {{ $value == "NL Netherlands" ? 'selected' : '' }} value="NL Netherlands">NL Netherlands</option>
    <option {{ $value == "NO Norway" ? 'selected' : '' }} value="NO Norway">NO Norway</option>
    <option {{ $value == "NP Nepal" ? 'selected' : '' }} value="NP Nepal">NP Nepal</option>
    <option {{ $value == "OM Oman" ? 'selected' : '' }} value="OM Oman">OM Oman</option>
    <option {{ $value == "PK Pakistan" ? 'selected' : '' }} value="PK Pakistan">PK Pakistan</option>
    <option {{ $value == "PL Poland" ? 'selected' : '' }} value="PL Poland">PL Poland</option>
    <option {{ $value == "PT Portugal" ? 'selected' : '' }} value="PT Portugal">PT Portugal</option>
    <option {{ $value == "QA Qatar" ? 'selected' : '' }} value="QA Qatar">QA Qatar</option>
    <option {{ $value == "RO Romania" ? 'selected' : '' }} value="RO Romania">RO Romania</option>
    <option {{ $value == "RS Serbia" ? 'selected' : '' }} value="RS Serbia">RS Serbia</option>
    <option {{ $value == "RU Russia" ? 'selected' : '' }} value="RU Russia">RU Russia</option>
    <option {{ $value == "SA Saudi Arabia" ? 'selected' : '' }} value="SA Saudi Arabia">SA Saudi Arabia</option>
    <option {{ $value == "SE Sweden" ? 'selected' : '' }} value="SE Sweden">SE Sweden</option>
    <option {{ $value == "SI Slovenia" ? 'selected' : '' }} value="SI Slovenia">SI Slovenia</option>
    <option {{ $value == "SK Slovakia" ? 'selected' : '' }} value="SK Slovakia">SK Slovakia</option>
    <option {{ $value == "SM San Marino" ? 'selected' : '' }} value="SM San Marino">SM San Marino</option>
    <option {{ $value == "SY Syria" ? 'selected' : '' }} value="SY Syria">SY Syria</option>
    <option {{ $value == "TJ Tajikistan" ? 'selected' : '' }} value="TJ Tajikistan">TJ Tajikistan</option>
    <option {{ $value == "TM Turkmenistan" ? 'selected' : '' }} value="TM Turkmenistan">TM Turkmenistan</option>
    <option {{ $value == "TN Tunisia" ? 'selected' : '' }} value="TN Tunisia">TN Tunisia</option>
    <option {{ $value == "TR Turkey" ? 'selected' : '' }} value="TR Turkey">TR Turkey</option>
    <option {{ $value == "UA Ukraine" ? 'selected' : '' }} value="UA Ukraine">UA Ukraine</option>
    <option {{ $value == "UZ Uzbekistan" ? 'selected' : '' }} value="UZ Uzbekistan">UZ Uzbekistan</option>
    <option {{ $value == "VA Vatican City" ? 'selected' : '' }} value="VA Vatican City">VA Vatican City</option>
    <option {{ $value == "YE Yemen" ? 'selected' : '' }} value="YE Yemen">YE Yemen</option>
</select>
