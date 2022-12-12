<?php
$lang->deploy->common           = 'Plan de d�ploiement';
$lang->deploy->create           = 'Cr�er un Plan de d�ploiement';
$lang->deploy->view             = 'D�tail D�ploiement';
$lang->deploy->finish           = 'Termin';
$lang->deploy->finishAction     = 'Terminer le d�ploiement';
$lang->deploy->edit             = 'Editer';
$lang->deploy->editAction       = 'Editer D�ploiement';
$lang->deploy->delete           = 'Supprimer';
$lang->deploy->deleteAction     = 'Supprimer D�ploiement';
$lang->deploy->deleted          = 'Deleted';
$lang->deploy->activate         = 'Activer';
$lang->deploy->activateAction   = 'Activer d�ploiement';
$lang->deploy->browse           = 'Deploiement';
$lang->deploy->scope            = 'Scope D�ploiement';
$lang->deploy->manageScope      = 'G�rer le Scope';
$lang->deploy->cases            = 'CasTests';
$lang->deploy->notify           = 'Notifier';
$lang->deploy->casesAction      = 'CasTests D�ploy�s';
$lang->deploy->linkCases        = 'Associer CasTest';
$lang->deploy->unlinkCase       = 'Dissocier CasTest';
$lang->deploy->steps            = 'Etape D�ploiement';
$lang->deploy->manageStep       = 'G�rer Etape';
$lang->deploy->finishStep       = 'Finir Etape';
$lang->deploy->activateStep     = 'Activer Etape';
$lang->deploy->assignTo         = 'Assigner ';
$lang->deploy->assignAction     = 'Assigner Etape';
$lang->deploy->editStep         = 'Editer Etape';
$lang->deploy->deleteStep       = 'Supprimer Etape';
$lang->deploy->viewStep         = 'D�tail Etape';
$lang->deploy->batchUnlinkCases = 'Dissocier par lot';
$lang->deploy->createdDate      = 'Date cr�ation';

$lang->deploy->name       = 'Nom du Plan';
$lang->deploy->desc       = 'Description';
$lang->deploy->members    = 'Membres';
$lang->deploy->hosts      = 'Serveurs';
$lang->deploy->service    = 'Service';
$lang->deploy->product    = 'Product';
$lang->deploy->release    = 'Release';
$lang->deploy->package    = 'Package URL';
$lang->deploy->begin      = 'D�but';
$lang->deploy->end        = 'Fin';
$lang->deploy->status     = 'Statut';
$lang->deploy->owner      = 'Propri�taire';
$lang->deploy->stage      = 'Phase';
$lang->deploy->ditto      = 'Idem';
$lang->deploy->manageAB   = 'G�rer';
$lang->deploy->title      = 'Titre';
$lang->deploy->content    = 'Contenu';
$lang->deploy->assignedTo = 'Assign';
$lang->deploy->finishedBy = 'Fini par';
$lang->deploy->createdBy  = 'Cr�� par';
$lang->deploy->result     = 'Resultat';
$lang->deploy->updateHost = 'Mise jour Serveurs';
$lang->deploy->removeHost = 'Serveurs supprimer';
$lang->deploy->addHost    = 'Nouveau Serveur';
$lang->deploy->hadHost    = 'H�berg';

$lang->deploy->lblBeginEnd = 'Dur�e';
$lang->deploy->lblBasic    = 'Information de Base';
$lang->deploy->lblProduct  = 'Liens';
$lang->deploy->lblMonth    = 'Courant';
$lang->deploy->toggle      = 'Bascule';

$lang->deploy->monthFormat = 'M Y';

$lang->deploy->statusList['wait'] = 'En attente';
$lang->deploy->statusList['done'] = 'Fait';

$lang->deploy->dateList['today']     = "Aujourd'hui";
$lang->deploy->dateList['tomorrow']  = 'Demain';
$lang->deploy->dateList['thisweek']  = 'Cette semaine';
$lang->deploy->dateList['thismonth'] = 'Ce mois';
$lang->deploy->dateList['done']      = $lang->deploy->statusList['done'];

$lang->deploy->stageList['wait']    = 'Avant d�ploiement';
$lang->deploy->stageList['doing']   = 'En D�ploiement';
$lang->deploy->stageList['testing'] = "Tests d'acceptance";
$lang->deploy->stageList['done']    = 'Apr�s D�ploiement';

$lang->deploy->resultList['']        = '';
$lang->deploy->resultList['success'] = 'Fait';
$lang->deploy->resultList['fail']    = 'Echec';

$lang->deploy->confirmDelete     = 'Voulez-vous supprimer ce d�ploiement ?';
$lang->deploy->confirmDeleteStep = 'Voulez-vous supprimer cette �tape ?';
$lang->deploy->errorTime         = "L'heure de fin doit �tre > l'heure de d�but !";
$lang->deploy->errorStatusWait   = 'If the status is Waiting, the FinishedBy should be empty';
$lang->deploy->errorStatusDone   = "Si l'�tat est En attente, FiniPar doit �tre vide";
$lang->deploy->errorOffline      = "Les serveurs dans Supprimer et Ajouter pour un service ne peuvent pas l'�tre en m�me temps.";
$lang->deploy->resultNotEmpty    = 'Le r�sultat ne peut pas �tre vide';

$lang->deploystep = new stdClass();
$lang->deploystep->status       = $lang->deploy->status;
$lang->deploystep->assignedTo   = $lang->deploy->assignedTo;
$lang->deploystep->finishedBy   = $lang->deploy->finishedBy;
$lang->deploystep->finishedDate = 'Finished Date';
$lang->deploystep->begin        = $lang->deploy->begin;
$lang->deploystep->end          = $lang->deploy->end;
