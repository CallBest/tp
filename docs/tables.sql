create database thriftypropane;

use thriftypropane;

grant select,update,insert on thriftypropane.* to propanemaster@localhost identified by 'propanemaster125!';
grant select,update,insert on thriftypropane.* to propanemaster@'%' identified by 'propanemaster125!';

DROP TABLE IF EXISTS users;
create table users (
	userid int(11) not null auto_increment,
	username varchar(50) not null default '',
	password varchar(50) not null default '',
	userfn varchar(50) not null default '',
	userln varchar(50) not null default '',
	usertype int(11) not null default 0,
	teamid int(11) not null default 0,
	datecreated datetime not null default '0000-00-00 00:00:00',
	lastlogin datetime not null default '0000-00-00 00:00:00',
	pwexpires date not null default '0000-00-00',
	active boolean not null default 1,
	primary key (userid)
) ENGINE=InnoDB AUTO_INCREMENT=101;

DROP TABLE IF EXISTS usertypes;
create table usertypes (
	usertype int(11) not null auto_increment,
	usertypedesc varchar(50) not null default '',
	primary key (usertype)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into usertypes (usertype,usertypedesc) values (1,'CSR');
insert into usertypes (usertype,usertypedesc) values (2,'Delivery Administrator');
insert into usertypes (usertype,usertypedesc) values (3,'Driver');
insert into usertypes (usertype,usertypedesc) values (4,'Sales Administrator');
insert into usertypes (usertype,usertypedesc) values (9,'Global Administrator');

insert into users (userid,username,password,userfn,userln,usertype,datecreated)
	values (1,'csr','23N28cKTfg.zQ','Customer Service','Representative',1,now()),
	(2,'delivery','23N28cKTfg.zQ','Delivery','Admin',2,now()),
	(3,'driver','23N28cKTfg.zQ','Mr','Driver',3,now()),
	(4,'sales','23N28cKTfg.zQ','Sales','Admin',4,now()),
	(5,'admin','23N28cKTfg.zQ','Global','Admin',9,now())	
	;

DROP TABLE IF EXISTS teams;
create table teams (
	teamid int(11) not null auto_increment,
	teamname varchar(50) not null default '',
	primary key (teamid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

DROP TABLE IF EXISTS userlogs;
create table userlogs (
	logid int(11) not null auto_increment,
	userid int(11) not null default 0,
	ipaddress varchar(20) not null default '',
	logdate datetime not null default '0000-00-00 00:00:00',
	action varchar(100) not null default '',
	actiondetails text not null default '',
	primary key (logid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

DROP TABLE IF EXISTS dispositions;
create table dispositions (
	dispoid int(11) not null auto_increment,
	disposition varchar(50) not null default '',
	dispocode varchar(20) not null default '',
	livecall boolean not null default 0,
	sale boolean not null default 0,
	callback boolean not null default 0,
	fresh boolean not null default 0,
	selectable boolean not null default 0,
	usertype int(11) not null default 0,
	primary key (dispoid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into dispositions (dispoid,disposition,dispocode,livecall,sale,callback,fresh,selectable,usertype)
	values
	(1,'New Customer','New Customer',0,0,0,1,0,0),
	(2,'Place Order','Place Order',0,0,0,1,1,0),
	(3,'For Delivery','For Delivery',0,0,0,1,1,2),
	(4,'Price Quote (No Sale)','Price Quote (No Sale)',0,0,0,1,1,0),
	(5,'Pre-buy Quote (No Sale)','Pre-buy Quote (No Sale)',0,0,0,1,1,0),
	(6,'Tank Quote (No Sale)','Tank Quote (No Sale)',0,0,0,1,1,0),
	(7,'Tank Purchase / LTO (No Sale)','Tank Purchase / LTO (No Sale)',0,0,0,1,1,0),
	(8,'Price Match Request','Price Match Request',0,0,0,1,1,0),
	(9,'Do Not Call','Do Not Call',0,0,0,1,1,0),
	(10,'Inquiry','Inquiry',0,0,0,1,1,0),
	(11,'Complaint','Complaint',0,0,0,1,1,0)
	;

DROP TABLE IF EXISTS masterfile;
create table masterfile (
	leadid int(11) not null auto_increment,
	lastname varchar(150) not null default '',
	firstname varchar(150) not null default '',
	phone varchar(100) not null default '',
	address varchar(100) not null default '',
	addresscity varchar(100) not null default '',
	addresscounty varchar(100) not null default '',
	addressstate varchar(50) not null default '',
	addresszipcode varchar(50) not null default '',
	email varchar(50) not null default '',
	remarks text not null default '',
	accountnumber int(11) not null default 0,
	referralcode varchar(50) not null default '',
	referralcredit float not null default 0.00,
	billingaddress varchar(100) not null default '',
	billingcity varchar(100) not null default '',
	billingcounty varchar(100) not null default '',
	billingstate varchar(100) not null default '',
	billingzipcode varchar(100) not null default '',
	modeofpayment varchar(20) not null default '',
	cardtype varchar(100) not null default '',
	cardnumber varchar(19) not null default '',
	expirationdate varchar(100) not null default '',
	cvv varchar(3) not null default '',
	creditcardzip varchar(100) not null default '',
	checkingaccountnumber varchar(100) not null default '',
	checkroutingnumber varchar(100) not null default '',
	countytax varchar(100) not null default '',
	haspricecap bit not null default 0,
	haspricecapppg varchar(100) not null default '',
	haspricecapexp varchar(100) not null default '',
	haslockin bit not null default 0,
	haslockinppg varchar(100) not null default '',
	haslockinexp varchar(100) not null default '',
	tiergalloncoverage varchar(100) not null default '',
	restrictedprebuygallons varchar(100) not null default '',
	taxexempt bit not null default 0,
	tankownership varchar(50) not null default '',
	tanksize varchar(100) not null default '',
	hasprebuyannualfee bit not null default 0,
	prebuyfeestartdate varchar(100) not null default '',
	serialnumber varchar(100) not null default '',
	tankannualmaintenancefee varchar(100) not null default '',
	maintenancefeestartdate varchar(100) not null default '',
	onbudgetprogram bit not null default 0,
	twelvemonthtankprogram bit not null default 0,
	permanentdeliveryinstructions varchar(100) not null default '',
	notes text not null default '',
	marknoservice bit not null default 0,
	markdrivewaydifficult bit not null default 0,
	problemcustomer bit not null default 0,
	disposition varchar(50) not null default '',
	userid int(11) not null default 0,
	tagdate datetime not null default '0000-00-00 00:00:00',
	primary key (leadid)
) ENGINE=InnoDB AUTO_INCREMENT=100001;

alter table masterfile add index (lastname);
alter table masterfile add index (firstname);
alter table masterfile add index (disposition);
alter table masterfile add index (userid);
alter table masterfile add index (tagdate);
alter table masterfile add index (address);
alter table masterfile add index (addresscity);
alter table masterfile add index (addressstate);
alter table masterfile add index (addresscounty);
alter table masterfile add index (addresszipcode);

DROP TABLE IF EXISTS clienthistory;
create table clienthistory (
	historyid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	remarks text not null default '',
	disposition varchar(50) not null default '',
	userid int(11) not null default 0,
	tagdate datetime not null default '0000-00-00 00:00:00',
	primary key (historyid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

alter table clienthistory add index (leadid);

DROP TABLE IF EXISTS orders;
create table orders (
	orderid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	ordertype varchar(50) not null default '',
	tanksize varchar(50) not null default '',
	gallons varchar(50) not null default '',
	ppg varchar(50) not null default '',
	expressdelivery bit not null default 0,
	billingaddress varchar(100) not null default '',
	billingcity varchar(100) not null default '',
	billingcounty varchar(100) not null default '',
	billingstate varchar(100) not null default '',
	billingzipcode varchar(100) not null default '',
	cardtype varchar(100) not null default '',
	cardnumber varchar(19) not null default '',
	expirationdate varchar(100) not null default '',
	cvv varchar (3) not null default '',
	creditcardzip varchar(100) not null default '',
	totalamount float not null default 0.00,
	orderdate datetime not null default '0000-00-00 00:00:00',
	paid bit not null default 0,
	paymethod varchar(10) not null default '',
	payamount float not null default 0.00,
	actiontaken enum('','Scheduled delivery','Declined') not null default '',
	delivered bit not null default 0,
	deliverydate datetime not null default '0000-00-00 00:00:00',
	primary key (orderid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

DROP TABLE IF EXISTS deliveries;
create table deliveries (
	deliveryid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	entereddate datetime not null default '0000-00-00 00:00:00',
	scheduled datetime not null default '0000-00-00 00:00:00',
	assigneddriver int(11) not null default 0,
	delivereddate datetime not null default '0000-00-00 00:00:00',
	gallonsppg varchar(50) not null default '',
	iscompleted bit not null default 0,
	isprebuy bit not null default 0,
	ispaid bit not null default 0,
	deliverystatus varchar(50) not null default '',
	deliverynotes text not null default '',
	onhold bit not null default 0,
	markpaid bit not null default 0,
	primary key (deliveryid)
) ENGINE=InnoDB AUTO_INCREMENT=1;