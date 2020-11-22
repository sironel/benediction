<?php

function nb_etudiants(){
  return( \App\Etudiant::all()->count());
}
function nb_cours(){
  return( \App\Cour::all()->count());
}

function nb_users(){
  $emailAuth = ['sironel2002@gmail.com','djenicarubes@gmail.com','lynceerubes@gmail.com'];
       $nbuser=\App\User::whereNotIn('email',$emailAuth)->where('user_level', '<>', 0)->count();

       return($nbuser);
}
function nb_profs(){
  return( \App\Professeur::all()->count());
}

function nb_etudiant_fille(){
  return( \App\Etudiant::where('sexe', 0)->count());
}
function nb_etudiant_garcon(){
  return( \App\Etudiant::where('sexe', 1)->count());
}

 function get_liste_etudiant_prof($user_id){
        $liste_an = get_liste_session_prof($user_id);
        $liste_etu = DB::table('etudiant_sessions')
         ->join('etudiants', 'etudiant_sessions.etudiant_id', 'etudiants.id')
          ->join('users', 'etudiants.user_id', 'users.id')
      ->whereIn('session_id', $liste_an)
        ->select('users.id','name' )
        ->orderBy('name', 'asc')
        ->get();
          return($liste_etu);
      }

  function get_session_prof($user){

    return \DB::table('cour_sessions')
      ->join('sessions', 'cour_sessions.session_id', 'sessions.id')
       ->join('nomsessions', 'sessions.nomsession_id', 'nomsessions.id')
        ->join('options', 'sessions.option_id', 'options.id')
        ->where('user_id', $user)
        ->where('cour_sessions.anac', config('Info.Anac'))
        ->select('titre', 'nomsession_id', 'sessions.id', 'option_id')
        ->orderBy('titre', 'asc')
        ->distinct()
        ->get();
  }
  function get_inscription($id){
  return \DB::table('inscriptions')
  ->join('facultes', 'inscriptions.faculte_id','facultes.id')
  ->join('options', 'inscriptions.option_id','options.id')
  ->where('inscriptions.id', $id)
  ->select('name','titre','inscriptions.id', 'no_trans', 'datepaie', 'nom', 'prenom', 'tel','email', 'inscriptions.created_at', 'datenais', 'lieunais','cin')
  ->get();
  }

  function get_liste_inscrit_by_fac(){
  return \DB::table('inscriptions')
  ->join('facultes', 'inscriptions.faculte_id','facultes.id')
  ->join('options', 'inscriptions.option_id','options.id')
 // ->where('facultes.id', $fac_id)
  ->select('name', 'titre','inscriptions.id', 'no_trans', 'datepaie', 'nom', 'prenom', 'tel','email', 'inscriptions.created_at', 'datenais', 'lieunais', 'np_pers', 'tel_pers','lien_parent','sexe','cin','nif', 'adresse')
  ->orderBy('nom', 'asc')
  ->get();
  }

  function get_inscrit_by_fac($fac_id){
    $query = DB::table('inscriptions');
    $query->join('facultes', 'inscriptions.faculte_id','facultes.id');
    $query->join('options', 'inscriptions.option_id','options.id');
    if($fac_id != 0 )
        $query->where('facultes.id', $fac_id);
      $query->select('name','inscriptions.id','titre', 'no_trans', 'datepaie', 'nom', 'prenom', 'tel','email', 'inscriptions.created_at', 'datenais', 'lieunais', 'np_pers', 'tel_pers','lien_parent','sexe','cin','nif', 'adresse');
    $query->orderBy('name', 'asc');
    $liste = $query->get();
    return $liste;
  }



  function total_inscrit_by_faculte(){
    return  DB::table('inscriptions')
                ->select('name',DB::raw('COUNT(inscriptions.id) as nb_insc'))
                 ->join('facultes','facultes.id','inscriptions.faculte_id')
                 ->groupBy('name')
                ->orderBy('name','asc')
                   ->get();

  }

  function annee_scol_suiv(){
    $annees = explode('-', config('Info.Anac'));
    $an = $annees[1];
    $ansuiv = $an + 1;
    return ($an.'-'.$ansuiv);
  }






  function get_liste_session_prof($user_id){
      $liste_annee =DB::table('cour_sessions')
      ->join('cours', 'cour_sessions.cour_id', 'cours.id')
       ->where('user_id', $user_id)
      ->select('session_id')
      ->groupBy('session_id')
      ->get();
        $i=0;
        $taban=[];
      foreach($liste_annee as $la){
        $taban[$i] = $la->session_id;
        $i++;
      }
        return($taban);
    }


  function get_liste_prof_by_session($session_id){
      $listeprofs = DB::table('cour_sessions')
      ->join('users', 'cour_sessions.user_id', 'users.id')
      ->where('user_level', config('Info.Professeur'))
      ->where('session_id', $session_id)
      ->select('users.id','name', 'email')
      ->orderBy('name', 'asc')
      ->groupBy('users.id','name', 'email')
      ->get()->toArray();
      return($listeprofs);
    }
 function get_liste_etudiant_session($session_id){

         $etudiants = DB::table('etudiant_sessions')
           ->join('etudiants','etudiant_sessions.etudiant_id','etudiants.id')
           ->join('users','etudiants.user_id','users.id')
           ->where('session_id',$session_id)
           ->where('anac','=', config('Info.Anac'))
           ->select('etudiants.id','nom','prenom', 'nin', 'users.id as user_id','name', 'naissance', 'lieu', 'session_id')
           ->get()->toArray();

           return($etudiants);
    }

  function liste_etudiant(){
   return \DB::table('etudiants')
        ->join('etudiant_sessions','etudiant_sessions.etudiant_id','etudiants.id')
       // ->join('sessions','etudiant_sessions.etudiant_id','sessions.id')
        ->join('users','etudiants.user_id','users.id')
        ->where('user_level', config('Info.Etudiant'))
        ->where('anac', config('Info.Anac'))
        ->orderBy('name', 'asc')
        ->select('users.id','name','session_id')
        ->get();
  }

 function send_message_int($message, $destinataire, $expediteur, $checkprof, $session_id=null){

      if($destinataire != -1){
          $user_level =\App\User::where('id', $expediteur)->pluck('user_level')[0];
          if($destinataire == 0){
          if( $user_level == config('Info.Etudiant'))
          {
            if($checkprof==2)
                 $liste_destinataire =get_liste_prof_by_session($session_id);
            if($checkprof==1){
            $liste_destinataire =get_liste_etudiant_session($session_id);
          }
          if($checkprof==3){
              $liste_destinataire = \App\User::where('user_level', config('Info.Recteur'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
          if($checkprof==4){
              $liste_destinataire = \App\User::where('user_level', config('Info.Doyen'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
        }
          if( $user_level == config('Info.Professeur'))
          {
            if($checkprof==2)
            $liste_destinataire = \App\User::where('user_level', config('Info.Professeur'))->orderBy('name', 'asc')->get();
            if($checkprof==1){

             if($session_id != null){
                if($session_id!=0)
                $liste_destinataire =get_liste_etudiant_session($session_id);
                else
                  $liste_destinataire = \App\User::where('user_level', config('Info.Etudiant'))->orderBy('name', 'asc')->get();
              }
          }
          if($checkprof==3){
              $liste_destinataire = \App\User::where('user_level', config('Info.Recteur'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
          if($checkprof==4){
              $liste_destinataire = \App\User::where('user_level', config('Info.Doyen'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
        }
          if( $user_level == config('Info.Recteur'))
           {
            if($checkprof==2)
            $liste_destinataire = \App\User::where('user_level', config('Info.Professeur'))->orderBy('name', 'asc')->get();
            if($checkprof==1){
              if($session_id != null){
                if($session_id!=0)
                $liste_destinataire =get_liste_etudiant_session($session_id);
                else
                  $liste_destinataire = \App\User::where('user_level', config('Info.Etudiant'))->orderBy('name', 'asc')->get();
              }

             }
            if($checkprof==3){
              $liste_destinataire = \App\User::where('user_level', config('Info.Recteur'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
              }
               if($checkprof==4){
              $liste_destinataire = \App\User::where('user_level', config('Info.Doyen'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
              }
           }

            if( $user_level == config('Info.Doyen'))
           {
            if($checkprof==2)
            $liste_destinataire = \App\User::where('user_level', config('Info.Professeur'))->orderBy('name', 'asc')->get();
            if($checkprof==1){
              if($session_id != null){
                if($session_id!=0)
                $liste_destinataire =get_liste_etudiant_session($session_id);
                else
                  $liste_destinataire = \App\User::where('user_level', config('Info.Etudiant'))->orderBy('name', 'asc')->get();
              }

             }
            if($checkprof==3){
              $liste_destinataire = \App\User::where('user_level', config('Info.Recteur'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
              }
              if($checkprof==4){
              $liste_destinataire = \App\User::where('user_level', config('Info.Doyen'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
              }
           }
                foreach ($liste_destinataire as $lp)
                {
                  $data =['expediteur'=>$expediteur,
                         'recepteur'=>$lp->id,
                         'message_id'=>$message,
                       ];
                  $mesageuser =store_data('Mesageuser', $data);

                }
              }else{
                      $data =['expediteur'=>$expediteur,
                           'recepteur'=>$destinataire,
                           'message_id'=>$message,
                         ];
                    $mesageuser =store_data('Mesageuser', $data);
                 }
                  if($mesageuser['status']==1)
                  return 1;
                  return 0;
                }
              }




     function send_message_interne($message, $destinataire, $expediteur, $checkprof, $session_id=null){

      if($destinataire != -1){
          if($destinataire == 0)
          {
            if($checkprof==2)
            $liste_destinataire =get_liste_prof_by_session($session_id);
            if($checkprof==1){
            $liste_destinataire =get_liste_etudiant_session($session_id);
          }
          if($checkprof==3){
              $liste_destinataire = \App\User::where('user_level', config('Info.Recteur'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
          if($checkprof==4){
              $liste_destinataire = \App\User::where('user_level', config('Info.Doyen'))->whereNotIn('email', ['djenicarubes@gmail.com','lynceerubes@gmail.com', 'sironel2002@gmail.com' ])->orderBy('name', 'asc')->get();
          }
                foreach ($liste_destinataire as $lp)
                {
                  $data =['expediteur'=>$expediteur,
                         'recepteur'=>$lp->id,
                         'message_id'=>$message,
                       ];
                  $mesageuser =store_data('Mesageuser', $data);

                }
          }
          else{
                    $data =['expediteur'=>$expediteur,
                           'recepteur'=>$destinataire,
                           'message_id'=>$message,
                         ];
                    $mesageuser =store_data('Mesageuser', $data);
              }


                  if($mesageuser['status']==1)
                  return 1;
                  return 0;
                }


    }

     function send_message_internep($message, $destinataire, $user){

      if($destinataire != -1){
          if($destinataire == 0)
          {

              $liste_destinataire =get_liste_etudiant_prof($user);
                foreach ($liste_destinataire as $lp)
                {
                  $data =['expediteur'=>$user,
                         'recepteur'=>$lp->id,
                         'message_id'=>$message,
                       ];
                  $mesageuser =store_data('Mesageuser', $data);
                }
          }
                  else{
                    $data =['expediteur'=>$user,
                           'recepteur'=>$destinataire,
                           'message_id'=>$message,
                         ];
                    $mesageuser =store_data('Mesageuser', $data);
                  }
                  if($mesageuser['status']==1)
                  return 1;
                  return 0;
      }

    }


     function nb_message_recu_non_lu($user){
      $liste_message = DB::table('mesageusers')
    ->where('recepteur', $user)
    ->where('trash', 0)
    ->where('lu', 0)
    ->select('id')
    ->get();
    $liste_env = DB::table('mesageusers')
    ->where('expediteur', $user)
    ->where('trash', 0)
      ->select('id')
    ->get();
    $nb_message = $liste_message->count();
    $n =0;
    foreach ($liste_env as $lm) {
       $nb_reponse_nl =check_reponse_non_lu($lm->id);
       if($nb_reponse_nl != -1)
        $n +=$nb_reponse_nl[1];
    }
      $nb_msg = $nb_message + $n;
    return($nb_msg);

    }

     function get_message($user, $recu){
        if($recu==1){
          $wrep = 'recepteur';
          $jrep = 'mesageusers.expediteur';
          $srep = 'expediteur as expediteur';
          $nom = 'name as nom';
        }
        else{
            $wrep='expediteur';
            $jrep='mesageusers.recepteur';
            $srep='recepteur as expediteur';
            $nom = 'name as nom';
            // $l_rep = DB::table('mesageusers')
            // ->join('users', 'mesageusers.recepteur', 'users.id')
            // ->where('expediteur', $user)
            // ->select('recepteur', 'name', 'mesageusers.message_id')
            // ->get();
            // return $l_rep;
        }
        // $l_rep = DB::table('mesageusers')
        // ->join('users', $jrep, 'users.id')
        // ->where($wrep, $user)
        // ->select($srep, 'name', 'mesageusers.message_id')
        // ->get();
        // return $l_rep;

        $liste_message = DB::table('mesageusers')
      ->join('users',   $jrep, 'users.id')
      ->join('messages', 'mesageusers.message_id', 'messages.id')
      ->where($wrep, $user)
      ->where('trash', 0)
      ->orWhere(function($query) use ($user, $wrep) {
                $query->where('mesageusers.expediteur', $user)
                      ->where('trashexp', 0)
                      ->where($wrep, $user)
                      ->where('trash', 1);
            })
      ->select($srep ,'recepteur as recepteur_id', $nom,
                'contenu','sujet', 'mesageusers.created_at', 'message_id',
                'mesageusers.id as id', 'lu')
      ->orderBy('mesageusers.created_at', 'desc')
      ->paginate(25);
      return($liste_message);
    }



      function get_message_user($user){
      $mr =get_message($user, 1);
      $me =get_message($user, 0);
      $msg_user = collect();
      if($me->count()>0){
      foreach ($me as $e) {
      $message=check_reponse_non_lu($e->id);
      if($message != -1){
        $e->created_at = $message[0];
        $e->lu = 0;
        $msg_user->push($e);
      }
       }
    }

        if($mr->count()>0){
         foreach ($mr as $r) {

         $msg_user->push($r);

       }
    }
        return $msg_user;
     }


  function set_message_lu($mesageuser_id){
  $message = \App\Mesageuser::find($mesageuser_id);
        if($message->lu==0){
          $message->lu=1;
          $message->save();
        }
      $reponses = \App\Reponse::where('mesageuser_id',$mesageuser_id)->get();
      foreach ($reponses as $rep) {
        $repo = \App\Reponse::find($rep->id);
        if($repo->lu==0){
          $repo->lu=1;
          $repo->save();
        }
      }
      return $message;
}

     function get_reponse(){
      $reponse = DB::table('reponses')
      ->join('mesageusers', 'reponses.mesageuser_id', 'mesageusers.id')
      ->join('users', 'reponses.expediteur', 'users.id')
      ->where('reponses.trash', 0)
      ->select('reponses.expediteur', 'name', 'reponses.created_at as date', 'msgreponse','reponses.lu', 'mesageuser_id')
      ->orderBy('reponses.created_at', 'asc')
      ->paginate(25);
      return ($reponse);
    }

   function check_reponse_non_lu($mesageuser_id){
      $rep_nl = \App\Reponse::where('mesageuser_id', $mesageuser_id)->where('lu', 0)->get();
      if($rep_nl->count() < 1)
        return -1;
      else{
         $rep = \App\Reponse::latest()->first();
        $tab[0] = $rep->created_at;
        $tab[1] = $rep_nl->count();
        return $tab;
    }
  }


     function get_liste_expediteur($u){
      $liste_exp = DB::table('mesageusers')
      ->join('users', 'mesageusers.expediteur', 'users.id')
      ->where('expediteur', $user)
      ->select('expediteur')
      ->get();
      return($liste_exp);
    }



function nb_etudiants_by_faculte(){//tous les facultes
  $nb_etudiants_faculte = DB::table('etudiant_sessions')
                ->select('facultes.name','facultes.id',  DB::raw('count(etudiant_id) as nb_etudiant'))
                 ->join('etudiants','etudiant_sessions.etudiant_id','etudiants.id')
                 ->join('sessions','etudiant_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->groupBy('facultes.name','facultes.id')
                ->orderBy('facultes.name', 'asc' )
                ->get();
           return($nb_etudiants_faculte);
        }

function get_events_by_faculte($faculte_id){

     return \DB::table('calendriers')
     ->join('sessions', 'calendriers.session_id', 'sessions.id')
     ->join('options', 'sessions.option_id', 'options.id')
     ->join('facultes', 'options.faculte_id', 'facultes.id')
     ->where('options.faculte_id', $faculte_id)
     ->select('nomsession_id', 'sessions.id as session_id', 'calendriers.id','titre_event', 'description', 'date_debut', 'date_fin')
     ->get();
}

function get_events_by_id( $calendrier_id){

     return \DB::table('calendriers')
     ->join('sessions', 'calendriers.session_id', 'sessions.id')
     ->join('options', 'sessions.option_id', 'options.id')
     ->join('facultes', 'options.faculte_id', 'facultes.id')
     ->where('calendriers.id', $calendrier_id)
     ->select('nomsession_id', 'sessions.id as session_id','calendriers.id', 'titre_event', 'description', 'date_debut', 'date_fin')
     ->get();
}

function get_liste_session(){
   return \DB::table('sessions')
        ->join('nomsessions', 'sessions.nomsession_id', 'nomsessions.id')
        ->join('options', 'sessions.option_id', 'options.id')
        ->select('titre', 'nomsession_id', 'sessions.id', 'option_id')
        ->orderBy('titre', 'asc')
        ->get();
}


function get_liste_session_doyen(){
  $user_id = \Auth::user()->id;
  $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
   return \DB::table('sessions')
        ->join('nomsessions', 'sessions.nomsession_id', 'nomsessions.id')
        ->join('options', 'sessions.option_id', 'options.id')
        ->join('facultes', 'options.faculte_id', 'facultes.id')
        ->where('options.faculte_id', $faculte_id)
        ->select('titre', 'nomsession_id', 'sessions.id', 'option_id')
        ->orderBy('titre', 'asc')
        ->get();
}


 function get_etudiant_id($user_id){
      $etudiant_id = DB::table('etudiants')->where('user_id', $user_id)->pluck('id');
      return($etudiant_id);
    }

 function get_liste_devoir($user_id){
     $liste= get_liste_devoir_id_remise($user_id);
     $cour=[];
      $session = get_etudiant_session($user_id);
   $lcour = get_liste_cour_by_session($session);
     for($i=0; $i<count($lcour); $i++){

              $cour[$i]=$lcour[$i]->id;
         }
       $now = new DateTime();
     $liste_devoir= DB::table('devoirs')
       ->join('cour_sessions','devoirs.cour_session_id','cour_sessions.id')
       ->join('cours','cour_sessions.cour_id','cours.id')
       ->where('date_remise','>=', date("Y-m-d"))
      ->whereIn('devoirs.cour_session_id',  $cour)
      ->whereNotIn('devoirs.id',  $liste)
       ->select('devoirs.id','libelle','remarque_prof','date_remise','devoir_path')
       ->get();
          return ($liste_devoir);
   }

    function get_liste_devoir_id_remise($user_id){
          $etudiant_id = get_etudiant_id($user_id);

            $liste_remise= DB::table('remises')
            ->where('etudiant_id',  $etudiant_id[0])
            ->select('devoir_id')
            ->get();
        $liste=[];
        for($i=0; $i<count($liste_remise); $i++){

                 $liste[$i]=$liste_remise[$i]->devoir_id;
        }

      return ($liste);
    }


     function get_liste_cour($user_id){
        $etudiant = DB::table('etudiants')->where('user_id', $user_id)->pluck('id');
        // $option = DB::table('etudiant_sessions')
        // ->join('sessions', 'etudiant_sessions.session_id', 'sessions.id')
        // ->join('options', 'sessions.option_id', 'options.id')
        // ->where('etudiant_id', $etudiant)
        // ->get();
        // //->pluck('option_id');

        $etudiant_session = get_etudiant_session($user_id);

        $liste_cour = DB::table('cour_sessions')
        ->join('sessions', 'cour_sessions.session_id', 'sessions.id')
        ->join('cours', 'cour_sessions.cour_id', 'cours.id')
        // ->join('options', 'sessions.option_id', 'options.id')
        //  ->where('sessions.option_id', $option)
         ->where('cour_sessions.id',$etudiant_session)
          ->select('cour_sessions.id','libelle')
        ->get();
        return($liste_cour);
     }

     function get_etudiant_session($user_id){
        $etudiant = DB::table('etudiants')->where('user_id', $user_id)->pluck('id');
        $etudiant_session = DB::table('etudiant_sessions')->where('etudiant_id', $etudiant)->where('anac',config('Info.Anac'))->pluck('session_id');

        return($etudiant_session[0]);
    }

     function get_info_niveau_etudiant($user_id){
      $etudiant_id=get_etudiant_id($user_id);
      $info_etudiant = DB::table('etudiant_sessions')
      ->join('etudiants', 'etudiant_sessions.etudiant_id', 'etudiants.id')
      ->join('sessions', 'etudiant_sessions.session_id', 'sessions.id')
      ->join('options', 'sessions.option_id', 'options.id')
      ->where('etudiant_id',$etudiant_id[0])
      ->where('anac',config('Info.Anac'))
      ->select('options.id', 'options.titre','session_id')
      ->get();
      return($info_etudiant);
    }

     function get_liste_cour_by_session($session_id){
     // $session = [($niveau*2)-1,$niveau*2];
      $liste_courclasse =DB::table('cour_sessions')
     ->join('sessions', 'cour_sessions.session_id', 'sessions.id')
      ->join('cours', 'cour_sessions.cour_id', 'cours.id')
      ->where('session_id', $session_id)
      ->select('cours.id as cour_id','cour_sessions.id','libelle', 'session_id', 'nomsession_id')
      ->get()->toArray();
      return($liste_courclasse);
    }

     function get_fichier_type($file){
        $ext = substr($file, -3);
        $listdoc_ext = array('doc','ocx','xls','lsx','ppt','ptx','pdf','psx','wps');
        $listimg_ext = array('png','jpg','gif','jpeg');
        $listsnd_ext = array('mp3','wav');
        $listvid_ext = array('mp4','avi');

       if(in_array($ext, $listimg_ext)){
       return '<i class="fa fa-image mx-2"></i>';
       }
       if(in_array($ext, $listvid_ext)){
         return '<i class="fa fa-film mx-2"></i>';
       }
      if(in_array($ext, $listdoc_ext)){
         return '<i class="fa fa-folder-open mx-2"></i>';
       }
      if(in_array($ext, $listsnd_ext)){
       return '<i class="fa fa-volume-up mx-2"></i>';
       }

       return 'unk';

    }

    function initial($str){
      $expname = explode(' ', $str);
      $init = '';
      for ($i=0; $i <count($expname) ; $i++)
        if($i<2)
          $init = $init.Str::substr($expname[$i], 0, 1);
        return strtoupper($init);
    }

    function get_event($session_id){
      return \App\Calendrier::where('anac', config('Info.Anac'))->where('session_id', $session_id)->orderBy('created_at', 'desc')->get();
    }

     function get_liste_cour_prof($user_id){
       $listecourprof = DB::table('cour_sessions')
      ->join('cours','cour_sessions.cour_id','cours.id')
      ->join('sessions','cour_sessions.session_id','sessions.id')
      ->join('options','sessions.option_id','options.id')
      ->where('user_id', $user_id)
      ->select('libelle', 'cour_sessions.id', 'options.id as option_id', 'titre', 'nomsession_id')->get();
      return($listecourprof);
    }

     function get_liste_devoir_prof($user_id){
      $user = auth()->user();
      $listedevoirprof = Devoir::where('user_id', $user_id)
      ->select('cour_session_id', 'devoir_path', 'date_remise')->get();
      return($listedevoirprof);
    }


    function get_coursession($cour_session_id){
      $coursession = \DB::table('cour_sessions')
      ->join('cours', 'cour_sessions.cour_id', 'cours.id')
      ->where('cour_sessions.id', $cour_session_id)
      ->select('cour_sessions.id', 'libelle', 'session_id')
      ->get();
      return($coursession[0]);
    }

   function get_cour_sessionview($session_id){
      $coursession = \DB::table('cour_sessions')
      ->join('cours', 'cour_sessions.cour_id', 'cours.id')
      ->where('anac', config('Info.Anac'))
      ->where('cour_sessions.session_id', $session_id)
      ->select('cour_sessions.id', 'libelle', 'session_id', 'cour_sessions.cour_id')
      ->get();
      $data= [];
      $i = 0;
      foreach ($coursession as $cs) {
        $data[$i] = $cs->cour_id;
        $i++;
      }
      $cours = \DB::table('cours')
      ->whereNotIn('cours.id', $data)
      ->select('id', 'libelle')
      ->get();
      return(['coursession'=>$coursession, 'cours'=>$cours]);
    }


function nb_etudiant_faculte($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
     $nb_etu_fac = DB::table('etudiant_sessions')
                ->select('titre','options.id',  DB::raw('count(etudiant_id) as nb_etudiant'))
                 ->join('sessions','etudiant_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                ->count();

           return($nb_etu_fac);
}

function nb_etudiant_sexef($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
    $nb_etu_fac = DB::table('etudiants')
                ->select('sexe','etudiants.id',  DB::raw('count(etudiant_id) as nb_etudiant'))
                 ->join('etudiant_sessions','etudiant_sessions.etudiant_id','etudiants.id')
                 ->join('sessions','etudiant_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                ->where('sexe',0)
                ->count();
           return($nb_etu_fac);
}

function nb_option($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
    $nb_option = DB::table('options')
                ->select('options.id',  DB::raw('count(options.id) as nb_option'))
                 ->join('sessions','sessions.option_id','sessions.id')
                 ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                 ->count();
           return($nb_option);
}

function nb_etudiant_sexeg($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
    $nb_etu_fac = DB::table('etudiants')
                ->select('sexe','etudiants.id',  DB::raw('count(etudiant_id) as nb_etudiant'))
                 ->join('etudiant_sessions','etudiant_sessions.etudiant_id','etudiants.id')
                 ->join('sessions','etudiant_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                ->count();

           return($nb_etu_fac);
}

function nb_cour_faculte($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
  $nb_cour_fac = DB::table('cour_sessions')
                ->select('libelle','cours.id','cour_sessions.id', 'options.id',  DB::raw('count(cour_id) as nb_cour'))
                 ->join('cours','cour_sessions.cour_id','cours.id')
                 ->join('sessions','cour_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                ->count();

           return($nb_cour_fac);
}

function nb_prof_faculte($user_id){// Doyen
    $faculte_id = \App\Doyen::where('user_id', $user_id)->pluck('faculte_id')[0];
  $nb_prof_fac = DB::table('professeurs')
                ->select('professeurs.id','cour_sessions.id', 'options.id',  DB::raw('count(user_id) as nb_prof'))
                 ->join('users','professeurs.user_id','users.id')
                 ->join('cour_sessions','cour_sessions.user_id','cour_sessions.id')
                 ->join('sessions','cour_sessions.session_id','sessions.id')
                 ->join('options','sessions.option_id','options.id')
                ->join('facultes','options.faculte_id','facultes.id')
                ->where('options.faculte_id',$faculte_id)
                ->count();
           return($nb_prof_fac);
}



   function format_id($nom, $sexe, $prenom, $idfac, $last_id) {
         $last_id = Str::substr($last_id, 4, 4);
         $etucount = (int) $last_id;
         $etucount++;
         $frmt = $etucount;

         if ($etucount<10){
            $frmt = "000".$frmt;
         }elseif ($etucount<100)
            {
               $frmt = "00".$frmt;
            }elseif ($etucount<1000)
              {
                 $frmt = "0".$frmt;
              }elseif ($etucount<10000)
                  {
                     $frmt = $frmt;
                  }


       return (Str::substr($nom, 0, 1).$sexe.Str::substr($prenom, 0, 1).$idfac.$frmt);
   }

   function client(){
     $data=[
    'nom'=>'Ronel',
    'prenom'=>'Similien', 
    'ville'=>'Fort-liberte',
    'adresse'=>'Dufour',
    'telephone'=>'33445566',
    'sexe'=>1
];
 $rec = store_data('Client', $data) ;
 return $rec;
   }

   function store_data($model, $donnee) {
      $modelname = 'App\\'.$model;
      $message ='';
      $status = 1;
      $data = collect();
      try {
         $data =new $modelname;

          foreach ($donnee as $key => $value) {
            $data->$key = $value;
          }
          $data->save();
      }
      catch(\Illuminate\Database\QueryException $ex){
           $message = $ex->getMessage();
           $status = 0;
          }

      return (compact(['data','status','message']));
   }

//supprimer des donnees en passant le model et id
//retourne 3 variables (data:la ligne inseree, status:0 si erreur; 1 si ok, message: message d'erreur si il y en a)
//
function delete_data($model, $id) {
      $modelname = 'App\\'.$model;
      $message ='';
      $status = 1;

      if($modelname::find($id)!= null)  {
            try {
              $modelname::destroy($id);
            }
            catch(\Illuminate\Database\QueryException $ex){
                 $message = $ex->getMessage();
                 $status = 0;
                }
       }
      else{
          $message = 'Donnée introuvable...';
          $status = 0;
        }
      return (compact(['id','status','message']));
   }



//Update de donnees dans une table via son model
// en passant le nom du model le id et les donnees sous forme['key'=>'value']
//retourne 3 variables (data:la ligne modifiee, status:0 si erreur; 1 si ok, message: message d'erreur si il y en a)
//
function update_data($model, $data,$id) {
      $modelname = 'App\\'.$model;
      $message ='';
      $status = 1;
      $data = collect();
        if($modelname::find($id)!= null)  {
          try {
             $data =$modelname::find($id);
              //for($i=0;$i<count($data);$i++){
              foreach ($data as $key => $value) {
                $data->$key = $value;
              }
              $data->save();
          }
          catch(\Illuminate\Database\QueryException $ex){
               $message = $ex->getMessage();
               $status = 0;
              }
           }
      else{
          $message = 'Donnée introuvable...';
          $status = 0;
        }
      return (compact(['data','status','message']));
   }
