<table width="598" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="598" height="297" align="left" valign="top" class="bg01"><table width="598" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="595" height="25" bgcolor="#D9D9D9" class="word"></td>
        </tr>
        <tr>
          <td valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$imagePath}title0_new.gif" width="563" height="45"></td>
        </tr>
        <tr>
          <td height="233" valign="top" class="123"><table width="588" border="0" cellspacing="8" cellpadding="2">
              <tr>
                <td width="10" height="189">&nbsp;</td>
                <td valign="top" class="word"><table width="535" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76" height="29" valign="top"><div align="center"><img src="{$imagePath}new_1.gif" width="74" height="29"></div></td>
                      <td width="115" valign="top"><div align="center"><img src="{$imagePath}new_2.gif" width="113" height="29"></div></td>
                      <td width="227" valign="top"><div align="center"><img src="{$imagePath}new_3.gif" width="225" height="29"></div></td>
                      <td width="117" valign="top"><div align="center"><img src="{$imagePath}new_4.gif" width="115" height="29"></div></td>
                    </tr>
                    <tr valign="top">
                      <td height="140" colspan="4" class="word"><table width="535" border="0" cellpadding="3" cellspacing="2" bordercolor="#CCCCCC">
                          {section name=counter loop=$newsList}
                          
                          {if $newsList[counter].level == "最低等級"}
                          <tr bgcolor="#dfdfdf" class="word"> {elseif $newsList[counter].level == "最高等級"}
                          <tr bgcolor="#E6E6FF" class="word"> {/if}
                            <td width="68" height="18">{$newsList[counter].date}</td>
                            <td width="110">{$newsList[counter].level}</td>
                            <td width="228"><a href="#" onClick="window.open('./news/content.php?a_id=1041&system=1&version=C', '', 'width=500,height=400,resizable=1,scrollbars=1');">{$newsList[counter].title}</a></td>
                            <td width="110">{$newsList[counter].viewNum}</td>
                            {if $isModifyOn == 1}
                            <form method="post" action="./systemNews_modify.php">
                              <td valign="top"><div align="center">
                                  <input type="submit" name="submit" value="修改">
                                </div></td>
                            </form>
                            {/if}
                            {if $isDeleteOn == 1}
                            <form method="post" action="./systemNews_delete.php">
                              <td valign="top"><div align="center">
                                  <input type="submit" name="submit" value="刪除">
                                </div></td>
                            </form>
                            {/if} </tr>
                          {/section}
                        </table></td>
                    </tr>
                    {if $newsNum > 10}
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><span class="word"><a href="index.php?show=all">更多新聞...</a></span></td>
                    </tr>
                    {/if}
                  </table></td>
                <td width="10">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
      </table></td>
  </tr>
</table>
