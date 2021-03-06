<?php
if(isset($_GET['hash']) && ($rq = sbr::getSbrCalc($_GET['hash'])) !== false) {
    switch($rq['currency']) {
        case exrates::BANK:
            $currency = "�� ���������� ����";
            break;
        case exrates::YM:
            $currency = "�� ������.������";
            break;
        case exrates::WMR:
            $currency = "�� WebMoney";
            break; 
    }
    
    $setting = array("usr_type"    => array('type' => $rq['usr_type'],
                                            'text' => $rq['usr_type']==sbr::FRL+1 ? '�����������' : '��������' 
                                   ),
                     "frl_type"    => array('type' => $rq['frl_type'] , 
                                            'text' => $rq['frl_type']==sbr::FT_PHYS?'���������� �����':'����������� �����'
                                   ),
                     "rez_type"    => array('type' => $rq['rez_type'],
                                            'text' => $rq['rez_type']==sbr::RT_RU?'���������� ��':'������������ ���������� ���������'
                                   ), 
                     "scheme_type" => array('type' => $rq['scheme_type'],
                                            'text' => $rq['scheme_type']==sbr::SCHEME_AGNT?'��������� �������':'������� �������' 
                                   ),   
                     "currency"    => array('type' => $rq['currency'],
                                            'text' => $currency
                                   ),
                     "calc_role"   => array('type' => 1,
                                            'text' => $rq['usr_type'] == sbr::FRL+1 ? '� �������������' : '� �����������'    
                                   )              
                                                           
                    );            
    ?>
    <script type="text/javascript">
    window.addEvent('domready', function() {
        $('bank_scheme').addEvent('click', function() {
            setValueInput('currency', <?= exrates::BANK ?>);        
        });
        sbr_calc($('calcForm'), 'recalc');
        checkRole(<?=($setting['usr_type']['type'])?>); 
    });
    </script>    
<?} else {
    
    if(is_emp()) {
        $_frl_type = array('type' => sbr::FT_PHYS, 'text' => '���������� �����');
        $_rez_type = array('type' => sbr::RT_RU, 'text' => '���������� ��');
    } else {
        $_frl_type = array('type' => $sbr->user_reqvs['form_type'] == sbr::FT_JURI ? sbr::FT_JURI : sbr::FT_PHYS, 
                           'text' => $sbr->user_reqvs['form_type'] == sbr::FT_JURI ? '����������� �����':'���������� �����');
        $_rez_type = array('type' => $sbr->user_reqvs['rez_type'] == sbr::RT_UABYKZ ? $sbr->user_reqvs['rez_type'] : sbr::RT_RU, 
                           'text' => $sbr->user_reqvs['rez_type'] == sbr::RT_UABYKZ ?'������������ ���������� ���������' : '���������� ��');
    }
    
    $setting = array("usr_type"    => array('type' => (is_emp() ? (sbr::EMP + 1) :  (sbr::FRL + 1)),
                                            'text' => is_emp() ? '��������' : '�����������' 
                                   ),
                     "frl_type"    => array('type' => $_frl_type['type'], 
                                            'text' => $_frl_type['text']
                                   ),
                     "rez_type"    => array('type' => $_rez_type['type'],
                                            'text' => $_rez_type['text'],
                                   ), 
                     "scheme_type" => array('type' => sbr::SCHEME_AGNT,
                                            'text' => '��������� �������' 
                                   ),   
                     "currency"    => array('type' => exrates::BANK,
                                            'text' => '�� ���������� ����'
                                   ),
                     "calc_role"   => array('type' => 1,
                                            'text' => '� �������������'    
                                   )                         
                    );
    ?>
    <script type="text/javascript">
    window.addEvent('domready', function() {
        $('bank_scheme').addEvent('click', function() {
            setValueInput('currency', <?= exrates::BANK ?>);        
        });
        checkRole(<?=($setting['usr_type']['type'])?>);
    });
    </script>  
<?}//if?>
<?= $sbr->isAdmin()? '<div class="norisk-admin c"><div class="norisk-in">' : ''?>   
<div class="tabs-in">				

<form action="" id="calcForm" class="overlay-cls">
<input type="hidden" name="usr_type" id="usr_type" value="<?= ( isset($rq['usr_type'])?$rq['usr_type']: $setting['usr_type']['type'] ) ?>" />
<input type="hidden" name="frl_type" id="frl_type" value="<?= isset($rq['frl_type'])?$rq['frl_type']: $setting['frl_type']['type'] ?>" />
<input type="hidden" name="residency" id="residency" value="<?= isset($rq['rez_type'])?$rq['rez_type']: $setting['rez_type']['type'] ?>" />
<input type="hidden" name="scheme_type" id="scheme_type" value="<?= isset($rq['scheme_type'])?$rq['scheme_type']: $setting['scheme_type']['type'] ?>"  />
<input type="hidden" name="currency" id="currency" value="<?= isset($rq['currency'])?$rq['currency']: $setting['currency']['type'] ?>" /> 

	<div class="b-layout b-layout_padleft_90">
		<div style="position:relative; left:-90px"><span class="b-layout__calc"></span></div>

		<h2 class="b-layout__title">����������� ����������� ������</h2>
		<p class="b-layout__txt">� ������� ������������ ������ ��������� ������ �������� � ������ �����, ������� �� ��������, ������ ������������, ��� ��������� � ���� ��������� �� ����������� ������.</p>
		<div class="b-layout__txt b-layout__txt_padtop_20 b-layout__txt_fontsize_15 b-layout__txt_bold b-layout__txt_lineheight_20">� &mdash;
		
		<div class="b-filter b-filter_height_15 b-filter_valign_top" id="first_block_tooltip">
			<div class="b-filter__body"><a class="b-filter__link b-filter__link_dot_0f71c8 b-filter__link_bold b-filter__link_fontsize_15" href="#"><?= $setting['usr_type']['text']?></a><span class="b-filter__arrow  b-filter__arrow_0f71c8  "></span></div>
			<div class="b-shadow b-shadow_marg_-32 b-filter__toggle b-filter__toggle_hide">
				<div class="b-shadow__right">
					<div class="b-shadow__left">
						<div class="b-shadow__top">
							<div class="b-shadow__bottom">
								<div class="b-shadow__body b-shadow__body_pad_15 b-shadow__body_bg_fff">
									<ul class="b-filter__list">
										<li class="b-filter__item b-filter__item_padbot_10"><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['usr_type']['type'] == sbr::FRL + 1?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="checkRole(1); setValueInput('usr_type', <?= (sbr::FRL + 1)?>);">�����������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['usr_type']['type'] == sbr::FRL + 1? "":"b-filter__marker_hide")?>"></span></li>
										<li class="b-filter__item "><a class="b-filter__link <?=($setting['usr_type']['type'] == sbr::EMP + 1?"b-filter__link_no":"b-filter__link_dot_0f71c8");?> b-filter__link_bold b-filter__link_fontsize_15" href="javascript:void(0)" onclick="checkRole(2); setValueInput('usr_type', <?= (sbr::EMP + 1 )?>);">��������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['usr_type']['type'] == sbr::EMP + 1? "":"b-filter__marker_hide")?>"></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="b-shadow__tl"></div>
				<div class="b-shadow__tr"></div>
				<div class="b-shadow__bl"></div>
				<div class="b-shadow__br"></div>
			</div>
		</div>, <span id="case_word">����������</span> 
		<div class="b-filter b-filter_height_15 b-filter_valign_top">
			<div class="b-filter__body"><a class="b-filter__link b-filter__link_dot_0f71c8 b-filter__link_bold b-filter__link_fontsize_15" href="#"><?= $setting['frl_type']['text']?></a><span class="b-filter__arrow  b-filter__arrow_0f71c8"></span>&#160;</div>
			<div class="b-shadow b-shadow_marg_-32 b-shadow_margleft_-52 b-filter__toggle b-filter__toggle_hide">
				<div class="b-shadow__right">
					<div class="b-shadow__left">
						<div class="b-shadow__top">
							<div class="b-shadow__bottom">
								<div class="b-shadow__body b-shadow__body_pad_15 b-shadow__body_bg_fff">
									<ul class="b-filter__list">
										<li class="b-filter__item b-filter__item_padbot_10">
												<div class="b-filter__item">
														<span class="b-tooltip b-tooltip_inline-block b-tooltip_margright_7 b-tooltip_valign_baseline"><span class="b-tooltip__ic"></span></span><a 
														class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['frl_type']['type']==sbr::FT_PHYS?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setBlockScheme(2); setValueInput('frl_type', <?= sbr::FT_PHYS?>); setBlockScheme(2, 1);">���������� �����</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['frl_type']['type']==sbr::FT_PHYS?"":"b-filter__marker_hide")?>"></span>&#160;
												</div>
				<div class="i-tooltip i-tooltip_hide">				
						<div class="b-tooltip b-tooltip_margtop_5 b-tooltip_margright_-15 b-tooltip_transparent b-tooltip_nosik_yes b-tooltip_close_yes b-tooltip_fontsize_11 b-tooltip_zoom_1">
							<div class="b-tooltip__right">
								<div class="b-tooltip__left">
									<div class="b-tooltip__top">
										<div class="b-tooltip__topright" style="width:207px;"></div>
										<div class="b-tooltip__bottom">
											<div class="b-tooltip__body b-tooltip__body_width_200">
												<div class="b-tooltip__txt">���������� ���� � ���������<br/> �������� ������ �����������,<br/> �������������� ���������������,<br/> �������������� ���������<br/> �������� � ������ ������<br/> ������������</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="b-tooltip__close"></div>
							<div class="b-tooltip__topleft"></div>
							<div class="b-tooltip__nosik"></div>
							<div class="b-tooltip__tl"></div>
							<div class="b-tooltip__tr"></div>
							<div class="b-tooltip__bl"></div>
							<div class="b-tooltip__br"></div>
						</div>
				</div>
										</li>
										<li class="b-filter__item">
												<div class="b-filter__item">
														<span class="b-tooltip b-tooltip_inline-block b-tooltip_margright_7 b-tooltip_valign_baseline "><span class="b-tooltip__ic"></span></span><a
														 class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['frl_type']['type']==sbr::FT_JURI?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('frl_type', <?= sbr::FT_JURI?>, 0); setBlockScheme(1);">����������� �����</a>
														<span class="b-filter__marker b-filter__marker_galka <?=($setting['frl_type']['type']==sbr::FT_JURI?"":"b-filter__marker_hide")?>"></span>
												</div>
				<div class="i-tooltip i-tooltip_hide">				
						<div class="b-tooltip b-tooltip_margtop_5 b-tooltip_margright_-15 b-tooltip_transparent b-tooltip_nosik_yes b-tooltip_close_yes b-tooltip_fontsize_11 b-tooltip_zoom_1">
							<div class="b-tooltip__right">
								<div class="b-tooltip__left">
									<div class="b-tooltip__top">
										<div class="b-tooltip__topright" style="width:207px;"></div>
										<div class="b-tooltip__bottom">
											<div class="b-tooltip__body b-tooltip__body_width_200">
												<div class="b-tooltip__txt">����������� ���� � ���,<br/> ���, ���, ������������, ���,<br/> �����������</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="b-tooltip__close"></div>
							<div class="b-tooltip__topleft"></div>
							<div class="b-tooltip__nosik"></div>
							<div class="b-tooltip__tl"></div>
							<div class="b-tooltip__tr"></div>
							<div class="b-tooltip__bl"></div>
							<div class="b-tooltip__br"></div>
						</div>
					</div>					
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="b-shadow__tl"></div>
				<div class="b-shadow__tr"></div>
				<div class="b-shadow__bl"></div>
				<div class="b-shadow__br"></div>
			</div>
		</div>

		<div class="b-filter b-filter_height_15 b-filter_valign_top" >
			<div class="b-filter__body"><a class="b-filter__link b-filter__link_dot_0f71c8 b-filter__link_bold b-filter__link_fontsize_15" href="#"><?= $setting['rez_type']['text']?></a><span class="b-filter__arrow  b-filter__arrow_0f71c8"></span>,</div><div 
			class="b-shadow b-shadow_marg_-32 b-filter__toggle b-filter__toggle_hide" id="shadow_rez_type">
				<div class="b-shadow__right">
					<div class="b-shadow__left">
						<div class="b-shadow__top">
							<div class="b-shadow__bottom">
								<div class="b-shadow__body b-shadow__body_pad_15 b-shadow__body_bg_fff">
									<ul class="b-filter__list">
										<li class="b-filter__item b-filter__item_padbot_10"><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['rez_type']['type']==sbr::RT_UABYKZ?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('residency', <?= sbr::RT_UABYKZ?>); ">������������ ���������� ���������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['rez_type']['type']==sbr::RT_UABYKZ ? "":"b-filter__marker_hide")?>"></span></li>
										<li class="b-filter__item "><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['rez_type']['type']==sbr::RT_RU?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('residency', <?= sbr::RT_RU?>);">���������� ��</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['rez_type']['type']==sbr::RT_RU ? "":"b-filter__marker_hide")?>"></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="b-shadow__tl"></div>
				<div class="b-shadow__tr"></div>
				<div class="b-shadow__bl"></div>
				<div class="b-shadow__br"></div>
			</div></div>
			<span id="second_block_tooltip"></span><span id="calc_role">���� ��������� <?=$setting['calc_role']['text']?></span> 

		<div class="b-filter b-filter_height_15 b-filter_valign_top">
			<div class="b-filter__body"><a class="b-filter__link b-filter__link_dot_0f71c8 b-filter__link_bold b-filter__link_fontsize_15" href="#"><?= $setting['scheme_type']['text']?></a><span class="b-filter__arrow  b-filter__arrow_0f71c8  "></span></div>
			<div class="b-shadow b-shadow_marg_-32 b-filter__toggle b-filter__toggle_hide">
				<div class="b-shadow__right">
					<div class="b-shadow__left">
						<div class="b-shadow__top">
							<div class="b-shadow__bottom">
								<div class="b-shadow__body b-shadow__body_pad_15 b-shadow__body_bg_fff">
									<ul class="b-filter__list">
										<li class="b-filter__item b-filter__item_padbot_10"><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['scheme_type']['type']==sbr::SCHEME_AGNT?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('scheme_type', <?= sbr::SCHEME_AGNT?>)">��������� �������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['scheme_type']['type']==sbr::SCHEME_AGNT?"":"b-filter__marker_hide")?>"></span></li>
										<li class="b-filter__item "><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['scheme_type']['type']==sbr::SCHEME_PDRD?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('scheme_type', <?= sbr::SCHEME_PDRD?>)">������� �������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['scheme_type']['type']==sbr::SCHEME_PDRD?"":"b-filter__marker_hide")?>"></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="b-shadow__tl"></div>
				<div class="b-shadow__tr"></div>
				<div class="b-shadow__bl"></div>
				<div class="b-shadow__br"></div>
			</div>
		</div>
		 
		   &#160;� ������� ������� 
			 
		<div class="b-filter b-filter_height_15 b-filter_valign_top">
			<div class="b-filter__body"><a class="b-filter__link b-filter__link_dot_0f71c8 b-filter__link_bold b-filter__link_fontsize_15" href="#"><?= $setting['currency']['text']?></a><span class="b-filter__arrow  b-filter__arrow_0f71c8  "></span></div>
			<div class="b-shadow b-shadow_baseline b-shadow_marg_-32 b-filter__toggle b-filter__toggle_hide">
				<div class="b-shadow__right">
					<div class="b-shadow__left">
						<div class="b-shadow__top">
							<div class="b-shadow__bottom">
								<div class="b-shadow__body b-shadow__body_pad_15 b-shadow__body_bg_fff">
									<ul class="b-filter__list" id="block_scheme"><li
										 class="b-filter__item <?=($setting['frl_type']['type']==sbr::FT_JURI? "" : "b-filter__item_padbot_10");?>"><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['currency']['type']==exrates::BANK?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" id="bank_scheme">�� ���������� ����</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['currency']['type']==exrates::BANK ?"":"b-filter__marker_hide")?>"></span></li><li
										 class="b-filter__item b-filter__item_padbot_10" <?=($setting['frl_type']['type']==sbr::FT_JURI?"style='display:none'":"");?>><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['currency']['type']==exrates::YM?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('currency', <?= exrates::YM ?>)">�� ������.������</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['currency']['type']==exrates::YM?"":"b-filter__marker_hide")?>"></span></li><li
										 class="b-filter__item " <?=($setting['frl_type']['type']==sbr::FT_JURI?"style='display:none'":"");?>><a class="b-filter__link b-filter__link_bold b-filter__link_fontsize_15 <?=($setting['currency']['type']==exrates::WMR?"b-filter__link_no":"b-filter__link_dot_0f71c8");?>" href="javascript:void(0)" onclick="setValueInput('currency', <?= exrates::WMR ?>)">�� WebMoney</a><span class="b-filter__marker b-filter__marker_galka <?=($setting['currency']['type']==exrates::WMR ?"":"b-filter__marker_hide")?>"></span></li></ul>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="b-shadow__tl"></div>
				<div class="b-shadow__tr"></div>
				<div class="b-shadow__bl"></div>
				<div class="b-shadow__br"></div>
			</div>
		</div>
			 
			 
			 </div>
		
		
		
		
		<div class="b-form b-form_padbot_40 b-form_padtop_30">
			<label class="b-form__name b-form__name_fontsize_15 b-form__name_bold b-form__name_color_6db335 b-form__name_width_200 b-form__name_padtop_1 b-form__name_relative" for="b-input__text2">������ �������</label>
			<div class="b-input b-input_inline-block b-input_width_100">
				<input class="b-input__text b-input__text_bold b-input__text_color_6db335" id="sbr_cost" type="text" name="sbr_cost" size="80" maxlength="10" value="<?=isset($rq)?$rq['sbr_cost']:""?>" />
			</div>
			<div class="b-form__txt b-form__txt_bold b-form__txt_fontsize_15 b-form__text_color_6db335 b-form__txt_padleft_10 b-form__txt_padtop_1 b-form__txt_relative">���.</div>
			<div class="b-form__txt b-form__txt_block b-form__text_color_6db335">��� ����� ����������� ��� �������� �������</div>
		</div>
		
<div id="first_block">		
    <div id="emp_block">
		<div class="b-form b-form_padtop_10" id="block_calc_emp">
			<label class="b-form__name b-form__name_fontsize_15 b-form__name_bold b-form__name_padtop_3 b-form__name_width_200" for="b-input__text1" id="block_calc_emp_text">�� ���������</label>
			<div class="b-input b-input_inline-block b-input_width_100">
				<input class="b-input__text b-input__text_bold" id="emp_cost" type="text" name="emp_cost" size="80" value="<?=isset($rq)?$rq['emp_cost']:""?>" maxlength="10"/>
			</div>
			<div class="b-form__txt b-form__txt_fontsize_15 b-form__txt_bold b-form__txt_padtop_2 b-form__txt_padleft_10">���.</div>

			<div class="b-form b-form_bordbot_double_ccc b-form_padbot_5 b-form_padtop_20 b-form_width_440  b-filter__toggle_hide table_title">
					<div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_float_right b-form__txt_color_4d  b-form__txt_baseline">% �� <div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_baseline b-form__text_color_6db335">������� �������</div></div>
					<div class="b-form__txt b-form__txt_width_200 b-form__txt_fontsize_11 b-form__txt_color_4d  b-form__txt_lineheight_1 b-form__txt_baseline">������� � ������� �������</div>
					<div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_color_4d  b-form__txt_lineheight_1 b-form__txt_baseline">�����, ���.</div>
			</div>

		</div>
		
		
<? foreach($sbr->getSchemes() as $sch) { ?>
    <? foreach ($sch['taxes'][1] as $id => $tax) { $is_tax_com = ($id == sbr::TAX_OLD_COM || $id == sbr::TAX_EMP_COM);?>
        <div class="b-form b-form_padbot_16 b-form_width_450 <?=($is_tax_com?"b-form_bordbot_f0 b-form_margbot_17":"")?>  b-filter__toggle_hide sbr_taxes" id="taxrow_<?=$sch['type'].'_'.$id?>">    
            <div class="b-form__txt b-form__txt_block ">
                <div class="b-form__txt b-form__txt_float_right b-form__txt_padright_10 b-form__txt_width_125"><div class="b-form__txt b-form__txt_inline-block b-form__txt_width_15 b-form__txt_align_right b-form__txt_fontsize_11 b-form__txt_lineheight_1   b-form__txt_color_4d fourth"><?= $tax['percent']*100 ?></div></div>
		        <span class="b-tooltip b-tooltip_inline-block b-tooltip_margright_7 b-tooltip_valign_baseline b-tooltip_margleft_-20"><span class="b-tooltip__ic"></span></span>
		        <div class="b-form__txt b-form__txt_fontsize_13 b-form__txt_width_190 b-form__txt_valign_top b-form__txt_color_4d">
		            <?= ($is_tax_com?"�������� Free-lance.ru":$tax['abbr']) ?>
		        </div>
                <span class="b-form__txt b-form__txt_valign_top  b-form__txt_inline b-form__txt_color_red">+</span><div class="b-form__txt b-form__txt_bold b-form__txt_valign_top b-form__txt_margright_-1 second">0.00</div>
		    </div>
		    <div class="i-tooltip i-tooltip_margright_-450 i-tooltip_hide">
                <div class="b-tooltip b-tooltip_transparent b-tooltip_nosik_yes b-tooltip_inline-block b-tooltip_close_yes">
                    <table class="b-tooltip__table" cellpadding="0" cellspacing="0">
                        <tr class="b-tooltip__row">
                            <td class="b-tooltip__cell">
                            <div class="b-tooltip__right">
                                <div class="b-tooltip__left">
                                    <div class="b-tooltip__top">
                                        <div class="b-tooltip__topright"></div>
    								    <div class="b-tooltip__bottom">
    									   <div class="b-tooltip__body">
    									       <div class="b-tooltip__txt"><?= sbr::getDescrTaxes($id)?></div>
    									   </div>
    									 </div>
    								</div>
    							</div>
    						</div>
    					    <div class="b-tooltip__close"></div>
    						<div class="b-tooltip__topleft"></div>
    						<div class="b-tooltip__nosik"></div>
    						<div class="b-tooltip__tl"></div>
    						<div class="b-tooltip__tr"></div>
    						<div class="b-tooltip__bl"></div>
    						<div class="b-tooltip__br"></div>
    						</td>
						</tr>
				    </table>
			     </div>
		    </div>   
		</div>   
    <? } //foreach ?>
<? }//foreach?>
    </div>
</div>		
<div id="second_block">	
    <div id="freelancer_block">	
        <div class="b-form" id="block_calc_freelance">
			<label class="b-form__name b-form__name_bold b-form__name_fontsize_15 b-form__name_width_200 b-form__name_padtop_2" for="b-input__text3" id="block_calc_frl_text">����������� �������</label>
			<div class="b-input b-input_inline-block b-input_width_100">
				<input class="b-input__text b-input__text_bold" id="frl_cost" type="text" name="frl_cost" size="80" maxlength="10" value="<?=isset($rq)?$rq['frl_cost']:""?>" />
			</div>
			<div class="b-form__txt b-form__txt_bold b-form__txt_fontsize_15 b-form__txt_padtop_2 b-form__txt_padleft_10">���. <span style="display:none" id="rating_get">� 100 ������ ��������</span></div>
			
			<div class="b-form b-form_bordbot_double_ccc b-form_padbot_5 b-form_padtop_20 b-form_width_440  b-filter__toggle_hide table_title">
					<div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_float_right b-form__txt_color_4d   b-form__txt_baseline">% �� <div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_baseline b-form__text_color_6db335">������� �������</div></div>
					<div class="b-form__txt b-form__txt_width_200 b-form__txt_fontsize_11 b-form__txt_color_4d  b-form__txt_lineheight_1 b-form__txt_baseline">������ �� ������� �������</div>
					<div class="b-form__txt b-form__txt_fontsize_11 b-form__txt_color_4d  b-form__txt_lineheight_1 b-form__txt_baseline">�����, ���.</div>
			</div>
			
		</div>
<? foreach($sbr->getSchemes() as $sch) { ?>
    <? if (isset($sch['taxes'][0])) foreach ($sch['taxes'][0] as $id => $tax) { $is_tax_com = ($id == sbr::TAX_OLD_COM || $id == sbr::TAX_FRL_COM); ?>
        <div class="b-form b-form_padbot_16 b-form_width_450 <?= ($is_tax_com?"b-form_bordbot_f0 b-form_margbot_17":"")?>  b-filter__toggle_hide sbr_taxes" id="taxrow_<?=$sch['type'].'_'.$id?>">
            <div class="b-form__txt b-form__txt_block ">
                <div class="b-form__txt b-form__txt_float_right b-form__txt_padright_10 b-form__txt_width_125 "><div class="b-form__txt b-form__txt_lineheight_1 b-form__txt_fontsize_11 b-form__txt_color_4d b-form__txt_inline-block b-form__txt_width_15 b-form__txt_align_right fourth"><?= $tax['percent']*100 ?></div></div>
                <span class="b-tooltip b-tooltip_inline-block b-tooltip_margright_7 b-tooltip_valign_baseline b-tooltip_margleft_-20"><span class="b-tooltip__ic"></span></span>
                <div class="b-form__txt b-form__txt_width_190 b-form__txt_fontsize_13 b-form__txt_valign_top b-form__txt_color_4d">
                    <?= ($is_tax_com?"�������� Free-lance.ru":$tax['abbr']) ?>
                </div>
                <span class="b-form__txt b-form__txt_valign_top b-form__txt_inline b-form__txt_color_red">&minus;</span><div class="b-form__txt b-form__txt_bold b-form__txt_valign_top b-form__txt_margright_-1 second">0.00</div>
            </div>
            <div class="i-tooltip i-tooltip_margright_-450 i-tooltip_hide">
                <div class="b-tooltip b-tooltip_transparent b-tooltip_nosik_yes b-tooltip_inline-block b-tooltip_close_yes">
                    <table class="b-tooltip__table" cellpadding="0" cellspacing="0"><tr class="b-tooltip__row"><td class="b-tooltip__cell">
					    <div class="b-tooltip__right">
					        <div class="b-tooltip__left">
					            <div class="b-tooltip__top">
					                <div class="b-tooltip__topright"></div>
								    <div class="b-tooltip__bottom">
									   <div class="b-tooltip__body">
									       <div class="b-tooltip__txt"><?= sbr::getDescrTaxes($id)?></div>
									   </div>
									</div>
								</div>
							</div>
						</div>
						<div class="b-tooltip__close"></div>
						<div class="b-tooltip__topleft"></div>
						<div class="b-tooltip__nosik"></div>
						<div class="b-tooltip__tl"></div>
						<div class="b-tooltip__tr"></div>
						<div class="b-tooltip__bl"></div>
						<div class="b-tooltip__br"></div>
					</td></tr></table>
				</div>
			</div>
        </div>
    <? } //foreach?>
<? } //foreach ?>
		
		
	</div>
</div>		
		<div class="errorBox" style="display:none"><img src="/images/ico_error.png" alt="" width="22" height="18" /> &nbsp;<span id="text_error"></span></div>
		<?/*
		<h2 class="b-layout__title b-layout__title_padtop_20 b-layout__title_padbot_20">���������� �������� � �������������</h2>
		<div class="b-form">
			<label class="b-form__name b-form__name_padtop_5 b-form__name_width_140 b-form__name_fontsize_13" for="b-input__text4">������ �� ���� ������</label>
			<div class="b-input b-input_height_20 b-input_inline-block b-input_width_300">
				<input id="b-input__text4" class="b-input__text b-input__text_bold" name="link_calc" type="text" size="80" value="www.free-lance.ru/calc/1Fdds53_23FgsE2" />
			</div>
			<div class="b-form__txt b-form__txt_fontsize_11 b-form__text_color_4d4d4d b-form__txt_padtop_5 b-form__txt_padleft_10 ">����������� � ����� ������</div>
		</div>*/?>
		<h2 class="b-layout__title b-layout__title_padtop_35 b-layout__title_padbot_20">���������� �������� <span id="link_role">� �������������</span></h2>
		<div class="b-form">
			<label class="b-form__name b-form__name_padtop_5 b-form__name_width_150 b-form__name_fontsize_13" for="b-input__text4">������ �� ���� ������</label>
			<div class="b-input b-input_height_20 b-input_inline-block b-input_width_360">
				<input id="hash_link" onclick="$(this).select();" class="b-input__text b-input__text_bold" name="link_calc" type="text" size="120" value="" />
			</div>
		</div>
		
		
	</div>
	</form>
<style type="text/css">
.fourth{ line-height:1; font-size:11px; vertical-align:baseline; color:#4d4d4d;}
</style>
</div>			
<?= $sbr->isAdmin()? '</div></div>' : ''?>