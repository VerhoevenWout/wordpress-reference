-- CREATE VENUE TABLE
-- DONE
DROP TABLE IF EXISTS `venues`;
CREATE TABLE `venues` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(1000) DEFAULT NULL,
  `Content` LONGTEXT NULL,
  `Information` LONGTEXT NULL,
  `CapacityTable` varchar(1000) NULL,
  `Picture` varchar(1000) DEFAULT NULL,
  `InformationPicture` varchar(1000) DEFAULT NULL,
  `Description` LONGTEXT,
  `Keywords` varchar(1000),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(1000) DEFAULT NULL,
  `PageKeywords` varchar(1000) DEFAULT NULL,
  `ContactEmail` varchar(1000) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(1000) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` varchar(1000) DEFAULT NULL,
  `Longitude` varchar(1000) DEFAULT NULL,
  `ShortTitle` varchar(1000) DEFAULT NULL,
  `Active` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venues`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle,
ShopProducts.Active
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308', '29911', '29912')
AND ShopProducts.Active = 1;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
DROP TABLE IF EXISTS `venuesLatLng`;
CREATE TABLE `venuesLatLng` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Latitude` varchar(255) DEFAULT NULL,
  `Longitude` varchar(255) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  `Active` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesLatLng`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.Title,
ShopProducts.MainId,
ShopProducts.City,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle,
ShopProducts.Active
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308', '29911', '29912')
AND ShopProducts.Active = 1;
-- LIMIT 50

-- nl, en, fr


'20308', '29911', '29912'


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE NL
-- DONE
DROP TABLE IF EXISTS `venuesNL`;
CREATE TABLE `venuesNL` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,

  `Active` int(11) DEFAULT NULL,
  
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesNL`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Active,

ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE EN
-- DONE
DROP TABLE IF EXISTS `venuesEN`;
CREATE TABLE `venuesEN` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,

  `Active` int(11) DEFAULT NULL,

  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesEN`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Active,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29911');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE FR
-- DONE
DROP TABLE IF EXISTS `venuesFR`;
CREATE TABLE `venuesFR` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,

  `Active` int(11) DEFAULT NULL,
  
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesFR`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Active,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29912');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUETABLES TABLE
-- DONE
DROP TABLE IF EXISTS `venueTables`;
CREATE TABLE `venueTables` (
  `Id` int(11) NOT NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  PRIMARY KEY (`Id`)
);


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUEIMAGES TABLE
-- DONE
-- FOR INSERT INTO VENUES
DROP TABLE IF EXISTS `venueImages`;
CREATE TABLE `venueImages` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `PageId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LIGGING PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLiggingParamsNL`;
CREATE TABLE `venueLiggingParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('9')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsEN`;
CREATE TABLE `venueLiggingParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('16') 
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsFR`;
CREATE TABLE `venueLiggingParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('18') 
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- NL/EN/FR

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT NL PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsNL`;
CREATE TABLE `venueFaciliteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('11')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT EN PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsEN`;
CREATE TABLE `venueFaciliteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('17')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT FR PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsFR`;
CREATE TABLE `venueFaciliteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('19')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueActiviteitParamsNL`;
CREATE TABLE `venueActiviteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10', '13', '12')
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2000')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsEN`;
CREATE TABLE `venueActiviteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2002')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsFR`;
CREATE TABLE `venueActiviteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2001')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsNL`;
CREATE TABLE `venueLocatieParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsEN`;
CREATE TABLE `venueLocatieParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('13')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsFR`;
CREATE TABLE `venueLocatieParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('12')
AND ShopProductsComAdvancedSearchCategoryFilters.ProductId in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;






DROP TABLE IF EXISTS `venueTables`;
CREATE TABLE `venueTables` (
  `Id` int(11) NOT NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueTables`
SELECT
  venues.Id,
  venues.Information,
  venues.CapacityTable
FROM venues
WHERE venues.Id in ('66554','66553','66552','66551','66549','66548','66547','66546','66545','66544','66543','66542','66541','66540','66539','66538','66537','66536','66535','66534','66533','66532','66531','66530','66529','66528','66527','66526','66525','66524','66523','66522','66521','66520','66519','66518','66517','66516','66515','66514','66513','66512','66511','66510','66509','66508','66507','66506','66505','66504','66503','66502','66501','66500','66499','66498','66497','66496','66495','66494','66493','66492','66491','66490','66489','66488','66487','66486','66485','66484','66483','66481','66480','66479','66478','66477','66476','66474','66473','66472','66471','66470','66469','66468','66467','66466','66465','66460','66459','66449','66448','66447','66427','66426','66412','66411','66410','66408','66407','66406','66401','66397','66385','66383','66375','66374','66373','66372','66371','66370','66369','66368','66367','66365','66363','66360','66338','66337','66294','66293','66292','66291','66272','66270','66269','66263','66262','66258','66225','66224','66217','66216','66215','66214','66208','66207','66206','66205','66202','66198','66197','66195','66194','66193','66192','66189','66187','66186','66151','66150','66149','66121','66112','66104','66063','66054','65998','65997','65993','65990','65989','65988','65952','65946','65921','65916','65895','65882','65881','65856','65823','65797','65620','65548','65546','65545','65544','65454','65453','65428','65427','65324','65301','65266','65136','65135','65096','65030','64558','64549','64403','64369','64347','64341','64332','63988','63987','63984','63983','63982','63978','59670','59567','59566','59565','59389','59388','58696','58693','58055','57943','57942','57939','46825','46824','46809','46807','46778','46710','46709','46673','46657','46647','46623','46622','46621','46497','46478','46467','46461','46460','46459','46457','46455','46454','46414','46405','46398','46396','46332','46320','46315','46314','46253','46225','46118','46108','46107','46103','46100','46061','46060','46059','46057','46056','46055','46054','46053','46051','46050','46039','46038','46037','46020','46019','46011','46008','45984','45983','45981','45980','45977','45965','45964','45963','45957','45952','45937','45936','45935','45934','45933','45932','45931','45930','45898','45895','45867','45866','45861','45860','45855','45847','45846','45831','45754','45753','45600','45554','45499','45486','45478','45473','45472','45471','45466','45446','45444','45430','45311')
;
-- LIMIT 500

UPDATE venueTables SET Information = replace(Information, '<h3>Capacity</h3>', '');























































































































































-- CREATE VENUE TABLE
-- DONE
DROP TABLE IF EXISTS `venues`;
CREATE TABLE `venues` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` varchar(255) DEFAULT NULL,
  `Longitude` varchar(255) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venues`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308', '29911', '29912');
-- LIMIT 50

-- nl, en, fr

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE NL
-- DONE
DROP TABLE IF EXISTS `venuesNL`;
CREATE TABLE `venuesNL` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,

  `Active` int(11) DEFAULT NULL,
  
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesNL`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Active,

ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE EN
-- DONE
DROP TABLE IF EXISTS `venuesEN`;
CREATE TABLE `venuesEN` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesEN`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29911');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE FR
-- DONE
DROP TABLE IF EXISTS `venuesFR`;
CREATE TABLE `venuesFR` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesFR`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29912');
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUETABLES TABLE
-- DONE
DROP TABLE IF EXISTS `venueTables`;
CREATE TABLE `venueTables` (
  `Id` int(11) NOT NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueTables`
SELECT
  venues.Id,
  venues.Information,
  venues.CapacityTable
FROM venues
-- LIMIT 500

UPDATE venueTables SET Information = replace(Information, '<h3>Capacity</h3>', '');

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUEIMAGES TABLE
-- DONE
-- FOR INSERT INTO VENUES
DROP TABLE IF EXISTS `venueImages`;
CREATE TABLE `venueImages` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `PageId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueImages`
SELECT
  ShopProductImages.Id,
  ShopProductImages.ShopProductId,
  GROUP_CONCAT(ShopProductImages.Picture),
  ShopProducts.PageId
FROM ShopProductImages
-- WHERE ShopProductImages.ShopProductId in ('45482', '45484', '45485')

INNER JOIN ShopProducts ON ShopProductImages.ShopProductId = ShopProducts.Id
WHERE ShopProducts.PageId in ('20308', '29911', '29912')

GROUP BY ShopProductImages.ShopProductId
-- LIMIT 500
-- FOR DOWNLOAD
DROP TABLE IF EXISTS `venueImagesNoConcat`;
CREATE TABLE `venueImagesNoConcat` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `PageId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueImagesNoConcat`
SELECT
  ShopProductImages.Id,
  ShopProductImages.ShopProductId,
  ShopProductImages.Picture,
  ShopProducts.PageId
FROM ShopProductImages
-- WHERE ShopProductImages.ShopProductId in ('45482', '45484', '45485')

INNER JOIN ShopProducts ON ShopProductImages.ShopProductId = ShopProducts.Id
WHERE ShopProducts.PageId in ('20308', '29911', '29912');

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LIGGING PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLiggingParamsNL`;
CREATE TABLE `venueLiggingParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('9')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsEN`;
CREATE TABLE `venueLiggingParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('16')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsFR`;
CREATE TABLE `venueLiggingParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('18')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- NL/EN/FR

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT NL PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsNL`;
CREATE TABLE `venueFaciliteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('11')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT EN PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsEN`;
CREATE TABLE `venueFaciliteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('17')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT FR PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsFR`;
CREATE TABLE `venueFaciliteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('19')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueActiviteitParamsNL`;
CREATE TABLE `venueActiviteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10', '13', '12')
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2000')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsEN`;
CREATE TABLE `venueActiviteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2001')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsFR`;
CREATE TABLE `venueActiviteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2002')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsNL`;
CREATE TABLE `venueLocatieParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsEN`;
CREATE TABLE `venueLocatieParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('13')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsFR`;
CREATE TABLE `venueLocatieParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('12')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;









-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- WOKING ON
-- DROP TABLE IF EXISTS `venueLinkedPages`;
-- CREATE TABLE `venueLinkedPages` (
--   `Id` int(11) NOT NULL,
--   `PageId` int(11) NOT NULL,
--   `MainId` int(11) DEFAULT NULL,
--   `LinkedPages` varchar(4000) DEFAULT NULL,
--   `LinkedPagesValue` varchar(4000) DEFAULT NULL,
--   PRIMARY KEY (`Id`)
-- );

-- INSERT INTO `venueLinkedPages`
-- SELECT
--   venues.Id,
--   venues.PageId,
--   venues.MainId,
--   venues.LinkedPages,
--   GROUP_CONCAT(Pages.Name)
-- FROM venues
-- INNER JOIN Pages ON venues.LinkedPages = Pages.Id
-- GROUP BY venues.Id







-- DROP TABLE IF EXISTS `venueLinkedPagesEN`;
-- CREATE TABLE `venueLinkedPagesEN` (
--   `Id` int(11) NOT NULL,
--   `NameSeoPage` varchar(4000) DEFAULT NULL,
--   `TitleSeoPage` varchar(4000) DEFAULT NULL,
--   PRIMARY KEY (`Id`)
-- );

-- INSERT INTO `venueLinkedPagesEN`
-- SELECT
--   Pages.Id,
--   Pages.Name,
--   Pages.Title
-- FROM Pages
-- WHERE Pages.WebsiteId = '233' AND Pages.Language = 'en' AND Pages.PageType = 'Productlist'





 SELECT A.Title,  
     Split.a.value('.', 'VARCHAR(100)') AS String  
 FROM  (SELECT Title,  
         CAST ('<M>' + REPLACE(LinkedPages, ',', '</M><M>') + '</M>' AS XML) AS String  
     FROM  venuesEN) AS A CROSS APPLY String.nodes ('/M') AS Split(a);

select Title, cs.LinkedPages --SplitData
from venuesEN
cross apply STRING_SPLIT (Data, ',') cs




INSERT INTO wp_url_hash_table ("hash", "url_params") 
values (098f6bcd4621d373cade4e832627b4f6,"{\\\"searchdata\\\":{\\\"lat\\\":\\\"50.8503396\\\",\\\"lng\\\":\\\"4.351710300000036\\\",\\\"radius\\\":\\\"1000\\\",\\\"persons\\\":\\\"all\\\",\\\"halls\\\":\\\"all\\\",\\\"taxs\\\":{\\\"activiteit\\\":\\\"all\\\",\\\"faciliteit\\\":[],\\\"ligging\\\":[],\\\"type_locatie\\\":[]}},\\\"location\\\":\\\"Brussel\\\"}")

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE PLAATS PARAMS TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venuePlaatsParams`;
-- CREATE TABLE `venuePlaatsParams` (
--   `ProductId` int(11) DEFAULT NULL,
--   `ComAdvancedSearchId` int(11) DEFAULT NULL,
--   `ConcatFilters` varchar(2000),
--   `ConcatFilterValues` varchar(2000)
-- );

-- INSERT INTO `venuePlaatsParams`
-- SELECT
--   ShopProductsComAdvancedSearchCategoryFilters.ProductId,
--   ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
--   GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
--   GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
-- FROM ShopProductsComAdvancedSearchCategoryFilters
-- INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('8', '15', '20')
-- GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CONCAT VENUESEARCH PARAMS TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venueSearchParams`;
-- CREATE TABLE `venueSearchParams` (
--   `ProductId` int(11) DEFAULT NULL,
--   `ComAdvancedSearchId` int(11) DEFAULT NULL,
--   `ConcatFilters` varchar(2000),
--   `ConcatFilterValues` varchar(2000)
-- );

-- INSERT INTO `venueSearchParams`
-- SELECT
--   ShopProductsComAdvancedSearchCategoryFilters.ProductId,
--   ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
--   GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
--   GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
-- FROM ShopProductsComAdvancedSearchCategoryFilters
-- INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- FILTER VENUETABLES TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venueTables`;
-- CREATE TABLE `venueTables` (
--   `Id` int(11) NOT NULL,
--   `ShopProductId` int(11) NOT NULL,
--   `Row` int(11) NOT NULL,
--   `Column` int(11) NOT NULL,
--   `Label` varchar(255) DEFAULT NULL,
--   PRIMARY KEY (`Id`)
-- );

-- INSERT INTO `venueTables`
-- SELECT
--   ShopProductValues.Id,
--   ShopProductValues.ShopProductId,
--   ShopProductValues.Row,
--   ShopProductValues.Column,
--   ShopProductValues.Label
-- FROM ShopProductValues
-- -- LIMIT 50
