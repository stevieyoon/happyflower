<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>리본메세지 도우미</title>
    <style>
        BODY { font-family: "굴림"; font-size: 9pt; color: #333333; margin-top: 0px; margin-right:
            0px; margin-bottom: 0px; margin-left: 0px; background-color:#FFFFFF; LINE-HEIGHT: 20pt }
        TD { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 15pt;}
        DIV { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 20pt }
        CENTER { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 20pt }
        PRE { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 20pt }
        INPUT { background-color:#FFFFFF; color:black; border:1x solid #C1C0C0; font-size: 9pt; font-family: Arial;};
        FORM { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 14pt }
        TEXTAREA { COLOR: #333333; FONT-SIZE: 9pt; LINE-HEIGHT: 12pt;  }
        OPTION { COLOR: #000000; FONT-SIZE: 9pt; LINE-HEIGHT: 14pt }
        SELECT { BACKGROUND-COLOR: #FFFFFF; COLOR: #FFFFFF; FONT-SIZE: 9pt; LINE-HEIGHT: 20pt }
        .INPUT_1 { background-color:#FCF8F2; color:black; border:1x solid #FCF8F2; font-size: 9pt; font-family: Arial; }
        A:link { text-decoration: none; color: #333333}
        A:visited { text-decoration: none; color: #333333}
        A:hover { text-decoration: none; color: #159F35}
    </style>
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script language="javascript">
        function send(a){
            //	alert(a);
            opener.$('.<?=$_REQUEST["class_name"]?>').val(a);
            window.close();
        }
    </script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="650"> <table width="550" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="550"><img src="/img/ribonmessagetopimg1.gif" width="550" height="55"></td>
                </tr>
                <tr>
                    <td height="114">

                        <table width="550"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="267" height="107" align="right" valign="top">
                                    <table width="263" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td colspan="3" height="9"><img src="/img/cardmessageboxline1.gif" width="263" height="9"></td>
                                        </tr>
                                        <tr>
                                            <td height="93" width="1" bgcolor="DEDDDD"></td>
                                            <td height="93" width="3"></td>
                                            <td width="259">
                                                <p><img src="img/ribbon_icon.gif" width="5" height="7">
                                                    <a href="#1">결혼</a> |<a href="#2">결혼기념일</a> |<a href="#3">출산</a>
                                                    |<a href="#4">생일/돌</a> |<a href="#5">개업/이전</a> <br>
                                                    <img src="img/ribbon_icon.gif" width="5" height="7">
                                                    <a href="#6">공연/전시회</a> | <a href="#7">입학/졸업</a> |
                                                    <a href="#8">우승/입선</a> | <a href="#9">이사</a><br>
                                                    <img src="img/ribbon_icon.gif" width="5" height="7">
                                                    <a href="#10">건축준공</a> | <a href="#11">교회</a> | <a href="#12">창립</a>
                                                    |<a href="#13"> 환자/위문</a> | <a href="#14">애도</a><br>
                                                    <img src="img/ribbon_icon.gif" width="5" height="7"> <a href="#15">승진/영전/취임/퇴임</a></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" height="5"><img src="/img/cardmessageboxline2.gif" width="263" height="5"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="283" height="114"><img src="/img/ribonmessagetopimg2.gif" width="283" height="114"></td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td height="16">&nbsp;<a name="#1"></a></td>
    </tr>
    <tr>
        <td height="878" bgcolor="#FFFFFF"><table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="510" height="25" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>결혼을 축하하는 말</strong></font></td>
                    <td width="26" align="center" bgcolor="#FFFFFF"></td>
                </tr>
                <tr>
                    <td height="40" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝結婚 (축결혼)')">祝結婚
                            (축결혼)</a>, <a href="javascript:send('祝華婚 (축화혼)')">祝華婚 (축화혼)</a>,
                        <a href="javascript:send('祝華婚축화혼(신부측)')">祝華婚축화혼(신부측)</a>,
                        <a href="javascript:send('祝結婚축결혼(신랑측)')">祝結婚축결혼(신랑측)</a>,
                        <a href="javascript:send('祝成婚 (축성혼)')">祝成婚
                            (축성혼)</a> <a href="javascript:send('祝約婚 (축약혼)')">祝約婚 (축약혼)</a> <a name="#2"></a><br />
                        <a href="javascript:send('結婚(결혼)을 祝賀(축하)합니다')">結婚(결혼)을 祝賀(축하)합니다</a>
                    </td>
                </tr>
                <tr>
                    <td height="40" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="img/ribbonst_icon.gif" width="6" height="8">
                            <strong>결혼 기념일</strong></font></td>
                </tr>
                <tr>
                    <td height="77" colspan="2" bgcolor="#FFFFFF"> <p><a href="javascript:send('紙婚式 (지혼식/1주년)')">紙婚式
                                (지혼식/1주년)</a>, <a href="javascript:send('藁婚式 (고혼식/2주년)')">藁婚式 (고혼식/2주년)</a>,
                            <a href="javascript:send('菓婚式 (과혼식/3주년)')">菓婚式 (과혼식/3주년)</a>, <a href="javascript:send('革婚式 (혁혼식/4주년)')">革婚式
                                (혁혼식/4주년)</a><br>
                            <a href="javascript:send('木婚式 (목혼식/5주년)')">木婚式 (목혼식/5주년)</a>, <a href="javascript:send('花婚式 (화혼식/7주년)')">花婚式
                                (화혼식/7주년)</a>, <a href="javascript:send('錫婚式 (석혼식/10주년)')">錫婚式 (석혼식/10주년)</a>,
                            <a href="javascript:send('摩婚式 (마혼식/12주년)')">摩婚式 (마혼식/12주년)</a><br>
                            <a href="javascript:send('銅婚式 (동혼식/15주년)')">銅婚式 (동혼식/15주년)</a>,
                            <a href="javascript:send('陶婚式 (도혼식/20주년)')">陶婚式 (도혼식/20주년)</a>,
                            <a href="javascript:send('銀婚式 (은혼식/25주년)')">銀婚式 (은혼식/25주년)</a><br>
                            <a href="javascript:send('眞珠婚式 (진주혼식/30주년)')">眞珠婚式 (진주혼식/30주년)</a>,
                            <a href="javascript:send('珊湖婚式 (산호혼식/35주년)')">珊湖婚式 (산호혼식/35주년)</a>,
                            <a href="javascript:send('紅玉婚式 (홍옥혼식/45주년)')">紅玉婚式 (홍옥혼식/45주년)</a><br>
                            <a href="javascript:send('金婚式 (금혼식/50주년)')">金婚式 (금혼식/50주년)</a>,
                            <a href="javascript:send('金剛婚式 (금강혼식/60주년)')">金剛婚式 (금강혼식/60주년)</a>,
                            <a href="javascript:send('回婚式 (회혼식/60주년)')">回婚式 (회혼식/60주년)</a><a name="#3"></a><br />
                            <a href="javascript:send('結婚記念日을 祝賀드립니다 (결혼기념일을 축하드립니다)')">結婚記念日을 祝賀드립니다 (결혼기념일을 축하드립니다)</a><br />

                            <span style='font-weight:bold;color:#0C8928'><출산></span><br />
                            <a href="javascript:send('祝公主誕生 (축공주탄생)')">祝公主誕生 (축공주탄생)</a><br />
                            <a href="javascript:send('祝王子誕生 (축왕자탄생)')">祝王子誕生 (축왕자탄생)</a><br />
                            <a href="javascript:send('순산을 축하하며 산모의 건강을 기원합니다')">순산을 축하하며 산모의 건강을 기원합니다</a><br />
                            <a href="javascript:send('이제 아빠 엄마가 되셨군요. 축하합니다')">이제 아빠 엄마가 되셨군요. 축하합니다</a><br />
                            <a href="javascript:send('사랑스런 아기의 탄생을 축하합니다')">사랑스런 아기의 탄생을 축하합니다</a><br />
                            <a href="javascript:send('왕자님 탄생을 축하합니다')">왕자님 탄생을 축하합니다</a><br />
                            <a href="javascript:send('공주님 탄생을 축하합니다')">공주님 탄생을 축하합니다</a><br />
                            <a href="javascript:send('得男(득남)을 祝賀(축하)합니다')">得男(득남)을 祝賀(축하)합니다</a><br />


                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>아기 탄생을 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="24" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝出産 (축출산)')">祝出産
                            (축출산)</a>, <a href="javascript:send('祝順産 (축순산)')">祝順産 (축순산)</a>, <a href="javascript:send('祝得男 (축득남)')">祝得男
                            (축득남)</a> , <a href="javascript:send('祝得女(축득녀)')">祝得女(축득녀)</a><a name="#4"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>생일을 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="44" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝生日 (축생일)')">祝生日
                            (축생일)</a>, <a href="javascript:send('祝生辰 (축생신)')">祝生辰 (축생신)</a>, <a href="javascript:send('祝回甲 (축회갑)')">祝回甲
                            (축회갑/만60세)</a>, <a href="javascript:send('祝壽宴 (축수연)')">祝壽宴 (축수연/만60세)</a><br> <a href="javascript:send('祝壽筵 (축수연)')">祝壽筵
                            (축수연/만60세)</a>, <a href="javascript:send('祝華甲 (축화갑)')">祝華甲 (축화갑/만60세)</a>, <a href="javascript:send('祝七旬 (축칠순)')">祝七旬 (축칠순/70세)</a>,
                        <a href="javascript:send('祝古稀 (축고희)')">祝古稀 (축고희/70세)</a><br>
                        <a href="javascript:send('祝稀壽 (축희수)')">祝稀壽 (축희수/77세)</a>, <a href="javascript:send('祝八旬 (축팔순)')">祝八旬 (축팔순/80세)</a>, <a href="javascript:send('祝傘壽 (축산수)')">祝傘壽
                            (축산수/80세)</a>, <a href="javascript:send('祝米壽宴 (축미수연)')">祝米壽宴 (축미수연/88세)</a><br>
                        <a href="javascript:send('祝九旬 (축구순)')">祝九旬 (축구순/90세)</a>, <a href="javascript:send('祝白壽 (축백수)')">祝白壽 (축백수/99세)</a>,
                        <a href="javascript:send('祝天壽 (축천수)')">祝天壽 (축천수/100세)</a><a name="#5"></a>
                        <br /><br />
                        <span style='font-weight:bold;color:#0C8928'><생일/돌></span><br />

                        <a href="javascript:send('생일을 축하합니다')">생일을 축하합니다</a><br />
                        <a href="javascript:send('생신을진심으로축하드리며,더욱건강하세요')">생신을진심으로축하드리며,더욱건강하세요</a><br />
                        <a href="javascript:send('生辰(생신)을 祝賀(축하)드립니다')">生辰(생신)을 祝賀(축하)드립니다</a><br />
                        <a href="javascript:send('아기의 첫 생일, 예쁘고 건강하게 자라주세요!!')">아기의 첫 생일, 예쁘고 건강하게 자라주세요!!</a><br />
                        <a href="javascript:send('아기의 첫돌을 축하하며 더욱 건강하게 자라길 기원합니다.')">아기의 첫돌을 축하하며 더욱 건강하게 자라길 기원합니다.</a><br />
                        <a href="javascript:send('아기의 행복한 탄생일을 축하해요!!')">아기의 행복한 탄생일을 축하해요!!</a><br />
                        <a href="javascript:send('첫돌을 맞이한 아기에게 더없이 큰 사랑과 축복이 깃들기를 바랄께요!!')">첫돌을 맞이한 아기에게 더없이 큰 사랑과 축복이 깃들기를 바랄께요!!</a><br />
                        <a href="javascript:send('첫돌을 축하하며, 더욱 건강하게 자라길 바란다.')">첫돌을 축하하며, 더욱 건강하게 자라길 바란다.</a><br /><br />



                    </td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>개업 및 평시에 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="41" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝開業 (축개업)')">祝開業
                            (축개업)</a>, <a href="javascript:send('祝發展 (축발전)')">祝發展 (축발전)</a>, <a href="javascript:send('祝盛業 (축성업)')">祝盛業
                            (축성업)</a>, <a href="javascript:send('祝繁榮 (축번영)')">祝繁榮 (축번영)</a><br>
                        <a href="javascript:send('祝移轉 (축이전)')">祝移轉 (축이전)</a>, <a href="javascript:send('祝開場 (축개장)')">祝開場
                            (축개장)</a>, <a href="javascript:send('祝開店 (축개점)')">祝開店 (축개점)</a>
                        , <a href="javascript:send('祝開院(축 개원)')">祝開院(축 개원)</a><a name="#6"></a>	<br />

                        <span style='font-weight:bold;color:#0C8928'><개업/이전></span><br />
                        <a href="javascript:send('祝擴張移轉 (축확장이전)')">祝擴張移轉 (축확장이전)</a><br />
                        <a href="javascript:send('개원을 축하하며 뜻한 일 모두 성취하시기 바랍니다')">개원을 축하하며 뜻한 일 모두 성취하시기 바랍니다</a><br />
                        <a href="javascript:send('開業을 祝賀합니다(개업을 축하합니다)')">開業을 祝賀합니다(개업을 축하합니다)</a><br />
                        <a href="javascript:send('無窮한 發展을 祈願합니다(무궁한 발전을 기원합니다)')">無窮한 發展을 祈願합니다(무궁한 발전을 기원합니다)</a><br />

                        <span style='font-weight:bold;color:#0C8928'><창립></span><br />
                        <a href="javascript:send('창립을 축하하며 앞날의 번영을 기원합니다.')">창립을 축하하며 앞날의 번영을 기원합니다.</a><br /><br />

                    </td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>전람회와 음악회를 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="39" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝展覽會 (축전람회)')">祝展覽會
                            (축전람회)</a>, <a href="javascript:send('祝展示會 (축전시회)')">祝展示會 (축전시회)</a>
                        , <a href="javascript:send('祝品評會 (축품평회)')">祝品評會 (축품평회)</a>, <a href="javascript:send('祝個人展 (축개인전)')">祝個人展
                            (축개인전)</a><br> <a href="javascript:send('祝博覽會 (축박람회)')">祝博覽會 (축박람회)</a>,
                        <a href="javascript:send('祝演奏會 (축연주회)')">祝演奏會 (축연주회) </a>, <a href="javascript:send('祝獨唱會 (축독창회)')">祝獨唱會
                            (축독창회)</a><a name="#7"></a><br />

                        <span style='font-weight:bold;color:#0C8928'><공연/전시회></span><br />
                        <a href="javascript:send('祝發表會(축발표회)')">祝發表會(축발표회)</a><br />
                        <a href="javascript:send('祝出版記念 (축출판기념)')">祝出版記念 (축출판기념)</a><br />
                        <a href="javascript:send('祝發刊 (축발간)')">祝發刊 (축발간)</a><br />
                        <a href="javascript:send('CONGRATULATIONS')">CONGRATULATIONS</a><br />
                    </td>
                </tr>
                <tr>
                    <td height="25" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>입학과 졸업을 축하하는 말</strong></font></td>
                    <td height="25" align="center" bgcolor="#FFFFFF"></td>
                </tr>
                <tr>
                    <td height="37" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝入學 (축입학)')">祝入學
                            (축입학) </a>, <a href="javascript:send('祝卒業 (축졸업)')">祝卒業 (축졸업)</a>,
                        <a href="javascript:send('祝合格 (축합격)')"> 祝合格 (축합격)</a>, <a href="javascript:send('祝博士學位記授與 (축박사학위기수여)')">祝博士學位記授與
                            (축박사학위기수여)</a><br> <a href="javascript:send('祝碩士學位記授與 (축석사학위기수여)')">祝碩士學位記授與
                            (축석사학위기수여)</a>, <a href="javascript:send('謹慰勞功 (근위노공/정년퇴임에 전하는 말)')">謹慰勞功
                            (근위노공/정년퇴임에 전하는 말)</a><a name="#8"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>우승,입선을 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="26" colspan="2" bgcolor="#FFFFFF"> <a href="javascript:send('祝優勝 (축우승)')">祝優勝
                            (축우승) </a>, <a href="javascript:send('祝施 (축시)')">祝施 (축시)</a>, <a href="javascript:send('祝當選 (축당선)')">
                            祝當選 (축당선)</a> , <a href="javascript:send('祝入選 (축입선)')">祝入選 (축입선)</a><a name="#9"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>이사를 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="26" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝入宅 (축입택)')">祝入宅
                            (축입택) </a>, <a href="javascript:send('祝入住 (축입주)')">祝入住 (축입주)</a>,
                        <a href="javascript:send('祝家和萬事成 (축가화만사성)')">祝家和萬事成 (축가화만사성)</a> <a name="#10"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>건축관계의 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="44" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝落成 (축낙성)')">祝落成
                            (축낙성) </a>, <a href="javascript:send('祝起工 (축기공)')">祝起工 (축기공)</a>,
                        <a href="javascript:send('祝着工 (축착공)')"> 祝着工 (축착공)</a>, <a href="javascript:send('祝竣工 (축준공)')">祝竣工
                            (축준공)</a><br> <a href="javascript:send('祝除慕式 (축제모식)')">祝除慕式 (축제모식)</a>,
                        <a href="javascript:send('祝開院 (축개원)')">祝開院 (축개원) </a>, <a href="javascript:send('祝開館 (축개관)')">祝開館
                            (축개관)</a>, <a href="javascript:send('祝開通 (축개통)')">祝開通 (축개통)</a><a name="#11"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>교회에서 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="38" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝長老長立 (축장로장립)')">祝長老長立
                            (축장로장립) </a>, <a href="javascript:send('祝勸士就任 (축권사취임)')">祝勸士就任 (축권사취임)</a>,
                        <a href="javascript:send('祝牧師委任 (축목사위임)')">祝牧師委任 (축목사위임)</a>, <a href="javascript:send('祝獻堂 (축헌당)')">祝獻堂
                            (축헌당)</a><br> <a href="javascript:send('祝入堂 (축입당)')">祝入堂 (축입당)</a>,
                        <a href="javascript:send('祝牧師按手 (축목사안수)')">祝牧師按手 (축목사안수) </a>, <a href="javascript:send('祝執事按手 (축집사안수)')">祝執事按手
                            (축집사안수)</a>, <a href="javascript:send('祝洗禮 (축세례)')">祝洗禮 (축세례)</a><a name="#12"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>회사 창립을 축하하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="29" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('祝創立 (축창립)')">祝創立
                            (축창립) </a>, <a href="javascript:send('週 (주)年記念 (년기념)')">週 (주)年記念 (년기념)</a>,
                        <a href="javascript:send('祝創刊 (축창간)')">祝創刊 (축창간)</a>, <a href="javascript:send('祝創設 (축창설)')">
                            祝創設 (축창설)</a><a name="#13"></a></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>환자를 위문하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="24" colspan="2" bgcolor="#FFFFFF"><a href="javascript:send('快癒 (쾌유)')">
                            快癒 (쾌유)</a>, <a href="javascript:send('祈祝快癒 (기축쾌유)')">祈祝快癒 (기축쾌유)</a>,
                        <a href="javascript:send('回春(회춘)')">回春(회춘)</a><a name="#14"></a><br />

                        <a href="javascript:send('快癒를 祈願합니다 (쾌유를 기원합니다)')">快癒를 祈願합니다 (쾌유를 기원합니다)</a><br />
                    </td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>죽음을 애도하는 말</strong></font></td>
                </tr>
                <tr>
                    <td height="37" colspan="2" bgcolor="#FFFFFF"> <p><a href="javascript:send('謹弔 (근조)')">
                                謹弔 (근조)</a>, <a href="javascript:send('賻儀 (부의)')">賻儀 (부의)</a>, <a href="javascript:send('弔意 (조의)')">弔意
                                (조의) </a>, <a href="javascript:send('弔悼 (조도)')">弔悼 (조도)</a>, <a href="javascript:send('追慕 (추모)')">追慕
                                (추모) </a>, <a href="javascript:send('追悼 (추도)')">追悼 (추도)</a>, <a href="javascript:send('慰靈  (위령)')">慰靈
                                (위령) </a><br>
                            <a href="javascript:send('哀棹 (애도)')">哀棹 (애도)</a>, <a href="javascript:send('四十九日齊 (49일제)')">
                                四十九日齊 (49일제)</a> , <a href="javascript:send('百日脫喪 (백일탈상)')">百日脫喪
                                (백일탈상)</a>, <a href="javascript:send('甲祀 (갑사)')">甲祀 (갑사/돌아가신분
                                회갑일)</a> <br> <a href="javascript:send('極樂往生 (극락왕생)')">極樂往生 (극락왕생/죽어서 극락세계에 다시 태어남)</a> ,
                            <a href="javascript:send('삼가 故人의 冥福을 빕니다')">삼가 故人의 冥福을 빕니다</a><br />

                            <span style='font-weight:bold;color:#0C8928'><애도></span><br />
                            <a href="javascript:send('追慕(추모)')">追慕(추모)</a><br />
                            <a href="javascript:send('昇華(승화)')">昇華(승화)</a><br />

                        </p></td>
                </tr>
                <tr>
                    <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#0C8928"><img src="/img/ribbonst_icon.gif" width="6" height="8">
                            <strong>승진/영전/취임</strong></font></td>
                </tr>
                <tr>
                    <td height="37" colspan="2" bgcolor="#FFFFFF"> <p><a href="javascript:send('祝 昇進(축 승진)')">
                                祝 昇進(축 승진)</a>, <a href="javascript:send('祝 榮轉(축 영전)')"> 祝 榮轉(축 영전)</a> , <a href="javascript:send('祝 就任(축 취임)')"> 祝 就任(축 취임)</a>
                            , <a href="javascript:send('祝 轉任 (축 전임)')"> 祝 轉任 (축 전임)</a> , <a href="javascript:send('祝 移任(축 이임)')"> 祝 移任(축 이임)</a>
                            , <a href="javascript:send('祝 轉役(축 전역)')"> 祝 轉役(축 전역)</a> , <a href="javascript:send('祝 榮進(축 영진)')"> 祝 榮進(축 영진)</a><a name="#15"></a><br />

                            <span style='font-weight:bold;color:#0C8928'><승진/영전/취임/퇴임></span><br />
                            <a href="javascript:send('祝離就任式 (축이취임식)')">祝離就任式 (축이취임식)</a><br />
                            <a href="javascript:send('祝創立○○周年 記念 (축창립○○주년 기념)')">祝創立○○周年 記念 (축창립○○주년 기념)</a><br />
                            <a href="javascript:send('祝 任官(축임관)')">祝 任官(축임관)</a><br />
                            <a href="javascript:send('祝 進級(축진급)')">祝 進級(축진급)</a><br />
                            <a href="javascript:send('祝赴任(축부임)')">祝赴任(축부임)</a><br />
                            <a href="javascript:send('祝停年退任 (축정년퇴임)')">祝停年退任 (축정년퇴임)</a><br />
                            <a href="javascript:send('頌功 (송공)')">頌功 (송공)</a><br />
                            <a href="javascript:send('謹祝 (근축)')">謹祝 (근축)</a><br />
                            <a href="javascript:send('赴任을 祝賀합니다(부임을 축하합니다)')">赴任을 祝賀합니다(부임을 축하합니다)</a><br />
                            <a href="javascript:send('昇進을 祝賀합니다(승진을 축하합니다)')">昇進을 祝賀합니다(승진을 축하합니다)</a><br />
                            <a href="javascript:send('榮轉을 祝賀합니다(영전을 축하합니다)')">榮轉을 祝賀합니다(영전을 축하합니다)</a><br />
                            <a href="javascript:send('就任을 祝賀합니다(취임을 축하합니다)')">就任을 祝賀합니다(취임을 축하합니다)</a><br />
                            <a href="javascript:send('그간 노고에 감사드립니다')">그간 노고에 감사드립니다</a><br />
                            <a href="javascript:send('앞날의 행운과 건강을 기원합니다')">앞날의 행운과 건강을 기원합니다</a><br />
                            <a href="javascript:send('새 인생의 출발점이 되시기 기원합니다')">새 인생의 출발점이 되시기 기원합니다</a><br />
                            <a href="javascript:send('명예로운 정년 퇴임하심을 축하합니다')">명예로운 정년 퇴임하심을 축하합니다</a><br />
                            <a href="javascript:send('진급을 축하하며 힘찬 전진을 기대합니다')">진급을 축하하며 힘찬 전진을 기대합니다</a><br />
                            <a href="javascript:send('취임을 경하하며 성공과 건투를 바랍니다')">취임을 경하하며 성공과 건투를 바랍니다</a><br />
                            <a href="javascript:send('승진을 축하하오며 더 큰 영광있기를 기원합니다')">승진을 축하하오며 더 큰 영광있기를 기원합니다</a><br />
                        </p></td>
                </tr>
            </table></td>
    </tr>
</table>
</body>
</html>
