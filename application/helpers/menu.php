<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//id, NAME, PARENT_ID, POSITION, ACCESS, LINK, FA-ICON, IS_MENU, FOR_MEMBERS
$menu = <<<EOF
1,Bulk SMS,0,,,fa fa-envelope,1,1
2,Send Bulk SMS,1,send_bulk_sms,message/bulksms,fa fa-plane,1,1
3,Send Free SMS,1,send_free_sms,message/bulksms/free,fa fa-plus,0,1
4,Message History,1,message_history,message/history,fa fa-plus,1,1
0,Delete Message History,1,delete_message_history,,fa fa-history,0,0
5,Draft,1,draft,message/draft,fa fa-plus,1,1
6,Scheduled (Pending) SMS,1,schedule,message/schedule,fa fa-plus,1,1
7,Phone Book,0,manage_phonebook,phonebook/view,fa fa-phone,1,1
8,Buy Airtime,0,buy_airtime,bill/buy_airtime,fa fa-credit-card,1,1
0,Buy E-Pins,0,buy_epins,bill/buy_epins,fa fa-credit-card,1,1
9,Buy Databundle,0,buy_dataplan,bill/buy_dataplan,fa fa-database,1,1
10,Pay Bill,0,,,fa fa-university,1,1
11,DSTV Subscription,10,dstv_bill,bill/pay/dstv,fa fa-television,1,1
12,GoTv Subscription,10,gotv_bill,bill/pay/gotv,fa fa-television,1,1
13,Startimes Subscription,10,startimes_bill,bill/pay/startimes,fa fa-television,1,1
14,Recharge Account,0,fund_wallet,wallet/fund,fa fa-archive,1,1
15,Transfer,0,transfer_fund,wallet/transfer,fa fa-exchange,1,1
16,Transfer To Bank,0,transfer_to_bank,,fa fa-exchange,0,1
17,Admin Tools,0,,,fa fa-shield,1,0
18,Manage Users,17,view_user,users/view,fa fa-users,1,0
0,Credit User Account,17,credit_user,users/credit_user,fa fa-plus,1,0
0,Manage Admin Credit,17,manage_admin_credit,,fa fa-plus,0,0
0,Debit User Account,17,debit_user,,fa fa-minus-square,0,0
0,Recharge User on Credit,17,allow_on_credit,,fa fa-minus-square,0,0
0,Change User Privilege,17,change_staff_privilege,,fa fa-edit,0,0
0,Change User Price,17,change_user_price,,fa fa-edit,0,0
0,Change User Gateway,17,change_user_gateway,,fa fa-edit,0,0
0,Delete User,17,delete_user,,fa fa-trash,0,0
19,Send Messages To Users,17,message_user,users/message,fa fa-envelope,1,0
20,SMS Users,17,sms_user,,fa fa-envelope,0,0
21,Manage Sender ID,17,manage_sender_id, admin/sender_id,fa fa-gg,1,0
22,E-pins,17,,,fa fa-map-pin,1,0
0,View E-pins,22,view_epins,epins/view,fa fa-map-pin,1,0
0,Manage E-pins,22,manage_epins,epins/manage,fa fa-map-pin,1,0
0,Delete Epins Category,22,delete_epin_category, ,fa fa-map-pin,0,0
0,Add/Upload Epins,22,upload_epins, ,fa fa-plus,0,0
0,Update/Delete Epins,22,update_epins, ,fa fa-plus,0,0
0,Manage VIP users,17,manage_vip,users/vip,fa fa-user-secret,1,0
0,Payment History,17,payment_history,bill/history/0/fund_wallet,fa fa-history,1,0
0,Notifications,17,manage_notifications,admin/notifications,fa fa-bell-o,1,0
0,Alerts,17,manage_alerts,admin/alerts,fa fa-exclamation-circle,1,0
0,Roles/Privileges,17,manage_role,users/role,fa fa-sitemap,1,0
23,Report,17,,,fa fa-book,1,0
0,Cash Flow Statement,23,view_cashflow,report/view,fa fa-bookmark,1,0
0,Manage Income,23,manage_income,report/report/income,fa fa-arrow-down,1,0
0,Manage Expenses,23,manage_expenses,report/report/expenses,fa fa-arrow-up,1,0
30,System Setting,0,,,fa fa-gears,1,0
31,General Setting,30,general_setting,setting/general,fa fa-gear,1,0
32,Gateway Setting,30,manage_gateway,setting/gateway,fa fa-link,1,0
0,Payment Gateway,30,payment_gateway,setting/payment_gateway,fa fa-money,1,0
33,Price/Rate Setting,30,manage_rate,setting/rate,fa fa-line-chart,1,0
34,Reseller Account,30,manage_reseller,reseller/view,fa fa-server,1,0
35,Site Theme,30,manage_theme,setting/theme,fa fa-newspaper-o,1,0
36,Pages,30,manage_page,setting/page,fa fa-bookmark,1,0
37,Transaction History,0,view_bill_history,bill/history,fa fa-history,1,1
0,Update Profile,0,update_profile,users/profile,fa fa-user,1,1
EOF;
//id, NAME, PARENT_ID, POSITION, ACCESS, LINK, FA-ICON, IS_MENU, FOR_MEMBERS

//23,Summary/Report,17,sms_summary,admin/sms_summary,fa fa-bar-chart,1,0
//24,Activity History,17,activity_history,admin/activity_history,fa fa-eye,1,0
//25,Financial Accounting,17,view_account,account/view,fa fa-money,1,0
//26,Manage Income,17,manage_income,account/incom,fa fa-arrow-circle-o-right,0,0
//27,Manage Expenses,17,manage_expense,account/expense,fa fa-arrow-circle-o-left,0,0
//28,Debtor Tracking,17,view_debtor,account/debtor,fa fa-id-card,1,0
//29,Manage Debtors,17,manage_debtor,,fa fa-id-card,0,0