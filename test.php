<?php



FROM DNSYSCONFIG 
     WHERE CtrlCode = '42086' AND code = HNOPD_PRESCRIP.DefaultRightCode) as DefaultRightCode,
     
     Case When HNOPD_PRESCRIP.DefaultRightCode in ('4100','2100','2105','2106','2108','2205','2211','2213','2215','2206','2208','2209','2210','2212','2214','3104','5100','5200','SC02','SC03','SC04','SC05','SC031','SC06','2207','CO01','CO02','CO03','CO04','11022','21002','1129','11291','11292','11293','1130') 
     then 'WI'
       When HNOPD_PRESCRIP.DefaultRightCode  in ('SC02','SC03','SC04','SC05','SC031','SC06','2207','CO01','CO02','CO03','CO04') 
     then 'SC+'
      When HNOPD_PRESCRIP.DefaultRightCode  in ('1129','11291','11292','11293','1130') 
     then 'Inter'

     Else 'SC'
     
     end as RightGroup





     Case When HNOPD_PRESCRIP.DefaultRightCode not in ('2100','2105','2106','2108','2205','2211','2213','2215','2206','2208','2209','2210','2212','2214','5100','5200') 
     then 'WI'
       When HNOPD_PRESCRIP.DefaultRightCode  in ('SC02','SC03','SC04','SC05','SC031','SC06','2207','CO01','CO02','CO03','CO04') 
     then 'SC+'
      When HNOPD_PRESCRIP.DefaultRightCode  in ('1129','11291','11292','11293','1130') 
     then 'Inter'



     ?>




     