<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese UTF-8 language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => '���٥�ȥ�������',
    2 => '-',
    3 => '����',
    4 => '���',
    5 => '�ܺ�',
    6 => '���٥�Ȥ��ɲ�',
    7 => '���줫��Υ��٥��',
    8 => '�Ŀͥ��������ˤ��Υ��٥�Ȥ��ɲä���ȡ��ָĿͥ��������פ�桼��������˥塼�������򤹤뤳�ȤǸ��뤳�Ȥ��Ǥ��ޤ���',
    9 => '�Ŀͥ����������ɲ�',
    10 => '�Ŀͥ�������������',
    11 => "���Υ��٥�Ȥ� %s�θĿͥ����������ɲ�",
    12 => '���٥��',
    13 => '����',
    14 => '��λ',
    15 => '�������������',
    16 => '��������',
    17 => '������',
    18 => '��λ��',
    19 => '���٥�Ⱦ�������',
    20 => '�����ȥ�',
    21 => '������',
    22 => 'URL',
    23 => '�ĿͤΥ��٥��',
    24 => '�����ȤΥ��٥��',
    25 => '-',
    26 => '���٥�Ȥ����',
    27 => "{$_CONF['site_name']}�˥��٥�Ȥ���Ƥ���ȡ����������ΤΥ�����������Ͽ����ޤ���<br>���Υ��������Υ��٥�Ȥϡ��ƥ桼����ɬ�פ˱����ƸĿͥ�����������Ͽ�Ǥ��ޤ���",
    28 => '�����ȥ�',
    29 => '��λ����',
    30 => '��������',
    31 => '�����Υ��٥��',
    32 => '����1',
    33 => '����2',
    34 => '��Į¼̾',
    35 => '��ƻ�ܸ�',
    36 => '͹���ֹ�',
    37 => '���٥�Ȥμ���',
    38 => '���٥�Ȥμ�����Խ�',
    39 => '���',
    40 => '���٥�Ȥ��ɲá�',
    41 => '���Υ�������',
    42 => '�Ŀͥ�������',
    43 => '���',
    44 => 'HTML�����ϻ��ѤǤ��ޤ���',
    45 => '���',
    46 => '�����ƥ�Υ��٥��',
    47 => '���٥�Ⱦ��10��',
    48 => '������',
    49 => '���Υ����Ȥˤϥ��٥�Ȥ��ʤ�����ï�⥤�٥�Ȥ򥯥�å����Ƥ��ʤ����Τɤ��餫�Τ褦�Ǥ���',
    50 => '���٥��',
    51 => '���'
);

$_LANG_CAL_SEARCH = array(
    'results' => '���٥�Ⱦ���θ������',
    'title' => '�����ȥ�',
    'date_time' => '����',
    'location' => '���',
    'description' => '�ܺ�'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '�ĿͤΥ��٥�Ȥ��ɲ�',
    9 => '%s ���٥��',
    10 => '���٥�ȡ�',
    11 => '���Υ�������',
    12 => '�Ŀͥ�������',
    25 => '��롧',
    26 => '����',
    27 => '��',
    28 => '�Ŀͥ���������',
    29 => '���Υ�������',
    30 => '���٥�Ȥ���',
    31 => '�ɲ�',
    32 => '���٥��',
    33 => '����',
    34 => '����',
    35 => '�ʰ��ɲ�',
    36 => '���',
    37 => '���Υ����ȤǤϡ��Ŀͥ���������ͭ���ˤ��Ƥ��ޤ���',
    38 => '�Ŀͥ��٥�ȥ��ǥ���',
    39 => '��',
    40 => '��',
    41 => '��',
    42 => '���Υ��٥�Ȥ��ɲ�',
    43 => '���٥�����',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '���٥�ȥ��ǥ���',
    2 => '���顼',
    3 => '��ƥ⡼��',
    4 => '���٥��URL',
    5 => '���٥�ȳ�������',
    6 => '���٥�Ƚ�λ����',
    7 => '���٥�Ȥξ��',
    8 => '���٥�Ȥξܺ�',
    9 => '(http://����Ϥ�Ƥ�������)',
    10 => '���٥�Ȥ����ա����֡������ȥ롢�ܺ٤����Ϥ��Ƥ���������',
    11 => '������������',
    12 => '���٥�Ȥ��Խ�������ϡ����Υ��٥�Ȥ��Խ���������򥯥�å����Ƥ������������������٥�Ȥ����硢��Ρֿ������٥�ȡפ򥯥�å����Ƥ������������ԡ�������ϴ�¸���٥�ȤΥ��ԡ���������򥯥�å����Ƥ���������',
    13 => '��Ƽ�',
    14 => '��������',
    15 => '��λ����',
    16 => '',
    17 => "�������¤Τʤ����٥�Ȥ��Խ����褦�Ȥ��ޤ��������ι԰٤ϵ�Ͽ����ޤ�����<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">���٥���Խ�����</a>����äƤ���������",
    18 => '',
    19 => '',
    20 => '��¸',
    21 => '����󥻥�',
    22 => '���',
    23 => '���������򤿤��������ꤷ�Ƥ���������',
    24 => '��λ�����򤿤��������ꤷ�Ƥ���������',
    25 => '��λ�����򤿤��������ꤷ�Ƥ���������'
);

$LANG_CAL_MESSAGE = array(
    'save'      => '���٥�Ȥ���¸����ޤ�����',
    'delete'    => '���٥�Ȥ��������ޤ�����',
    'private'   => '���٥�Ȥ��Ŀͥ�����������¸����ޤ�����',
    'login'     => '�Ŀͥ��������򳫤��ˤϡ��ǽ�˥������󤷤Ƥ���������',
    'removed'   => '�Ŀͥ����������饤�٥�Ȥ��������ޤ�����',
    'noprivate' => '����������ޤ��󤬡����Υ����ȤǤϡ��Ŀͥ���������̵���Ǥ���',
    'unauth'    => '����������ޤ��󤬡����٥�ȴ����ڡ����˥����������븢�¤�����ޤ��󡣤��Υ��������ϵ�Ͽ�����Ƥ��������ޤ����ΤǤ�λ������������',
);

$PLG_calendar_MESSAGE4  = "{$_CONF['site_name']}�˥��٥�Ȥ���Ƥ��Ƥ������������꤬�Ȥ��������ޤ��������åդ��������졢��ǧ�Ԥ��ξ��֤ˤʤäƤ��ޤ�����ǧ���줿��硢���Υ����Ȥ�<a href=\"{$_CONF['site_url']}/calendar/index.php\">��������</a>����������ɽ������ޤ���";
$PLG_calendar_MESSAGE17 = '���٥�Ȥ���¸����ޤ�����';
$PLG_calendar_MESSAGE18 = '���٥�Ȥ��������ޤ�����';
$PLG_calendar_MESSAGE24 = '���٥�Ȥ��Ŀͥ�����������¸����ޤ�����';
$PLG_calendar_MESSAGE26 = '���٥�Ȥ��������ޤ�����';

?>