<div class="txtcenter">

    <form name="uploadForm" id="uploadForm">
        <{securityToken}><{*//mb*}>
        <{$categorySelect}>
        <input type="hidden" name="step" value="enreg">
        <input type="hidden" name="photo_title" value="">
        <input type="hidden" name="photo_desc" value="">
    </form>
    <br>
    <!-- --------------------------------------------------------------------------------------------------- -->
    <!-- --------     A DUMMY APPLET, THAT ALLOWS THE NAVIGATOR TO CHECK THAT JAVA IS INSTALLED   ---------- -->
    <!-- --------               If no Java: Java installation is prompted to the user.            ---------- -->
    <!-- --------------------------------------------------------------------------------------------------- -->
    <!--"CONVERTED_APPLET"-->
    <!-- HTML CONVERTER -->
    <script language="JavaScript" type="text/javascript"><!--
        var _info = navigator.userAgent;
        var _ns = false;
        var _ns6 = false;
        var _ie = (_info.indexOf("MSIE") > 0 && _info.indexOf("Win") > 0 && _info.indexOf("Windows 3.1") < 0);
        //--></script>
    <comment>
        <script language="JavaScript" type="text/javascript"><!--
            var _ns = (navigator.appName.indexOf("Netscape") >= 0 && ((_info.indexOf("Win") > 0 && _info.indexOf("Win16") < 0 && java.lang.System.getProperty("os.version").indexOf("3.5") < 0) || (_info.indexOf("Sun") > 0) || (_info.indexOf("Linux") > 0) || (_info.indexOf("AIX") > 0) || (_info.indexOf("OS/2") > 0) || (_info.indexOf("IRIX") > 0)));
            var _ns6 = ((_ns === true) && (_info.indexOf("Mozilla/5") >= 0));
            //--></script>
    </comment>

    <script language="JavaScript" type="text/javascript"><!--
        if (_ie === true) document.writeln('<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" WIDTH = "0" HEIGHT = "0" NAME = "JUploadApplet"  codebase="http://java.sun.com/update/1.5.0/jinstall-1_5-windows-i586.cab#Version=5,0,0,3"><noembed><xmp>');
        else if (_ns === true && _ns6 === false) document.writeln('<embed ' +
                'type="application/x-java-applet;version=1.5" \
                    CODEBASE = "<{$xoops_url}>/modules/extgallery/include/applet" \
            ARCHIVE = "<{$xoops_url}>/modules/extgallery/include/applet/wjhk.jupload.jar" \
            CODE = "wjhk.jupload2.EmptyApplet" \
            NAME = "JUploadApplet" \
            WIDTH = "0" \
            HEIGHT = "0" \
            type ="application/x-java-applet;version=1.6" \
            scriptable ="false" ' +
                'scriptable=false ' +
                'pluginspage="http://java.sun.com/products/plugin/index.html#download"><noembed><xmp>');
        //--></script>
    <object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
            codebase="http://java.sun.com/products/plugin/autodl/jinstall-1_4-windows-i586.cab#Version=1,4,0,0">
        <param name="CODEBASE" value="<{$xoops_url}>/modules/extgallery/include/applet">
        <param name="ARCHIVE" value="<{$xoops_url}>/modules/extgallery/include/applet/wjhk.jupload.jar">
        <param name="CODE" value="wjhk.jupload2.EmptyApplet">
        <param name="WIDTH" value="0">
        <param name="HEIGHT" value="0">
        <param name="NAME" value="JUploadApplet">
        </xmp>
        <PARAM NAME=CODE VALUE="wjhk.jupload2.EmptyApplet">
        <PARAM NAME=ARCHIVE VALUE="wjhk.jupload.jar">
        <PARAM NAME=NAME VALUE="JUploadApplet">
        <param name="type" value="application/x-java-applet;version=1.5">
        <param name="scriptable" value="false">
        <PARAM NAME="type" VALUE="application/x-java-applet;version=1.6">
        <PARAM NAME="scriptable" VALUE="false">

        </xmp>

        Java 1.5 or higher plugin required.
        <!--[if !IE]> -->
        <object type="application/x-java-applet">
            <param name="CODEBASE" value="<{$xoops_url}>/modules/extgallery/include/applet">
            <param name="ARCHIVE" value="<{$xoops_url}>/modules/extgallery/include/applet/wjhk.jupload.jar">
            <param name="CODE" value="wjhk.jupload2.EmptyApplet">
            <param name="WIDTH" value="0">
            <param name="HEIGHT" value="0">
            <param name="NAME" value="JUploadApplet">
            </xmp>
            <PARAM NAME=CODE VALUE="wjhk.jupload2.EmptyApplet" type="application/x-java-applet">
            <PARAM NAME=ARCHIVE VALUE="wjhk.jupload.jar" type="application/x-java-applet">
            <PARAM NAME=NAME VALUE="JUploadApplet" type="application/x-java-applet">
            <param name="type" value="application/x-java-applet;version=1.5" type="application/x-java-applet">
            <param name="scriptable" value="false" type="application/x-java-applet">
            <PARAM NAME="type" VALUE="application/x-java-applet;version=1.6" type="application/x-java-applet">
            <PARAM NAME="scriptable" VALUE="false">

            </xmp>

            Java 1.5 or higher plugin required.
        </object>
        <!-- <![endif]-->
    </object>
    </noembed>
    </embed>
    </object>

    <object
            width="640" height="600" classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
            codebase="http://java.sun.com/products/plugin/autodl/jinstall-1_4-windows-i586.cab#Version=1,4,0,0">
        <param name="postURL" value="<{$xoops_url}>/modules/extgallery/public-post-applet.php">
        <param name="uploadPolicy" value="PictureUploadPolicy">
        <param name="maxChunkSize" value="<{$maxphotosize}>">
        <param name="nbFilesPerRequest" value="1">
        <param name="debugLevel" value="0">
        <param name="lookAndFeel" value="system">
        <param name="maxPicHeight" value="<{$imageHeight}>">
        <param name="realMaxPicHeight" value="<{$imageHeight}>">
        <param name="maxPicWidth" value="<{$imageWidth}>">
        <param name="realMaxPicWidth" value="<{$imageWidth}>">
        <param name="pictureCompressionQuality" value="<{$imageQuality}>">
        <param name="showLogWindow" value="false">
        <param name="showStatusBar" value="false">
        <param name="lang" value="<{$appletLang}>">
        <param name="formdata" value="uploadForm">
        <param name="codebase" value="<{$xoops_url}>/modules/extgallery/include/applet">
        <param name="code" value="wjhk.jupload2.JUploadApplet">
        <param name="archive" value="<{$xoops_url}>/modules/extgallery/include/applet/wjhk.jupload.jar">
        <param name="alt" value="">
        <!-- Optionnal, see code comments --> Java 1.5 or higher
        plugin required. <!--[if !IE]> -->
        <object width="640" height="600" type="application/x-java-applet">
            <param name="postURL" value="<{$xoops_url}>/modules/extgallery/public-post-applet.php">
            <param name="uploadPolicy" value="PictureUploadPolicy">
            <param name="maxChunkSize" value="<{$maxphotosize}>">
            <param name="nbFilesPerRequest" value="1">
            <param name="debugLevel" value="0">
            <param name="lookAndFeel" value="system">
            <param name="maxPicHeight" value="<{$imageHeight}>">
            <param name="realMaxPicHeight" value="<{$imageHeight}>">
            <param name="maxPicWidth" value="<{$imageWidth}>">
            <param name="realMaxPicWidth" value="<{$imageWidth}>">
            <param name="pictureCompressionQuality" value="<{$imageQuality}>">
            <param name="showLogWindow" value="false">
            <param name="showStatusBar" value="false">
            <param name="lang" value="<{$appletLang}>">
            <param name="formdata" value="uploadForm">
            <param name="codebase" value="<{$xoops_url}>/modules/extgallery/include/applet">
            <param name="code" value="wjhk.jupload2.JUploadApplet">
            <param name="archive" value="<{$xoops_url}>/modules/extgallery/include/applet/wjhk.jupload.jar">
            <param name="alt" value="">
            <!-- Optionnal, see code comments --> Java 1.5 or higher
            plugin required.
        </object>
        <!-- <![endif]-->
    </object>

</div>
