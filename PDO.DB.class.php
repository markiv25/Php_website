<?php

class DB { 

    private $dbh;

    function __construct()
    {
       try{

        $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);

       } catch(PDOException $pe){
           echo $pe->getMessage();
           die("Bad Database");

       }
    }
    function check($id,$pwd,$rl){
      
        try{
            $stmt = $this->dbh->prepare(" 
                SELECT attendee.idattendee,attendee.role FROM attendee WHERE name = :id AND password = :pwd AND role =:rl ");
            $stmt->execute(["id"=>$id,"pwd"=> $pwd, "rl"=> $rl]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
            

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return false;
       }
    } //Check if User Exits in DB.

    function getAllEvents(){
        try{
            $data = array();
            include_once "./Events.class.php";
            $stmt = $this->dbh->prepare("select event.name,event.idevent, event.datestart, event.dateend, event.numberallowed, venue.name as venue_name
            FROM event
            INNER JOIN venue ON event.venue=venue.idvenue
            
            ");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Events");
            while($attendee = $stmt->fetch()){
                $data[] = $attendee;
            }
            return $data;
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }//getAll Events

    function getsess($id){
        try{
            $data = array();
            require_once "./Session.class.php";
            $stmt = $this->dbh->prepare("select * from session where event = :id");
            

            $stmt->execute(array(":id"=>$id));

            $stmt->setFetchMode(PDO::FETCH_CLASS,"Session");
            while($event = $stmt->fetch()){
                $data[] = $event;
            }
            return $data;


       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }//GetAllSession.

    function delete_usr($id,$session){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("delete
            from attendee_session 
            where attendee_session.attendee = :id AND attendee_session.session =:session;
            ");
            

            $stmt->execute(["id"=>$id,"session"=> $session]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }



       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    function getuserReg($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("select DISTINCT  session.idsession as id,event.idevent as event_id, session.name as session_name, session.startdate, session.enddate, event.name,venue.name as venue,attendee_event.paid as paid 
            from attendee_session 
            INNER JOIN session ON attendee_session.session = session.idsession
            INNER JOIN event ON session.event = event.idevent
            INNER JOIN venue ON event.venue = venue.idvenue
            INNER JOIN attendee_event ON attendee_event.event = event.idevent
            where attendee_session.attendee = :id");
            

            $stmt->bindParam(":id", intval($id),PDO::PARAM_INT);
            $stmt->execute();

            while($event = $stmt->fetch()){
                $data[] = $event;
            }
            return $data;



       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
//_____ADMIN______EVENT PAG____________
    function update_admin_session($id,$nm,$srt,$end,$num){
        try{
            $stmt = $this->dbh->prepare("update session
            SET startdate= :srt, name= :nm, enddate= :end, numberallowed= :num
            WHERE session.idsession = :id");

            $stmt->execute(["id"=>$id,"nm"=>$nm,"srt"=>$srt,"end"=>$end,"num"=>$num]);
            return $this->dbh->lastInsertId();

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return -1;
      }
    }//Update SEssion
    function update_admin_event($id,$nm,$srt,$end,$num,$venue){
        try{
            $stmt = $this->dbh->prepare("update event
            SET datestart= :srt, name= :nm, dateend= :end, numberallowed= :num, venue= :venue
            WHERE event.idevent = :id");

            $stmt->execute(["id"=>$id,"nm"=>$nm,"srt"=>$srt,"end"=>$end,"num"=>$num,"venue"=>$venue]);
            return $this->dbh->lastInsertId();

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return -1;
      }
    }//ADmin Event
    function update_admin_venue($id,$name,$cap){
        try{
            $stmt = $this->dbh->prepare("update venue
            SET name= :name, capacity= :cap
            WHERE idvenue = :id");

            $stmt->execute(["name"=>$name,"cap"=>$cap,"id"=>$id]);

            return $this->dbh->lastInsertId();

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return -1;
      }
    }
    function update_admin_user($id,$name,$role){
        try{
            $stmt = $this->dbh->prepare("update attendee
            SET name= :name, role= :role
            WHERE idattendee = :id");

            $stmt->execute(["name"=>$name,"role"=>$role,"id"=>$id]);

            return $this->dbh->lastInsertId();

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return -1;
      }
    }
    function admin_num($event){
        try{
            $stmt = $this->dbh->prepare(
            " select  session.numberallowed
            from session
            where session.event= :event ");
            $stmt->execute(array(":event"=>$event));
         
            while($row = $stmt->fetch()){
             
               $data[]=$row;
                
            }
            return $data;

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
    function update_event_admin($id,$NUM,$venue_name,$venue_id){
        try{
            $stmt = $this->dbh->prepare(" 
      
            UPDATE  venue
            SET venue.name=:venue_name
            WHERE venue.idvenue=:venue_id; 

            update event
            SET event.numberallowed=:NUM
            WHERE event.idevent=:id;

            update session
            SET session.numberallowed=:NUM
            WHERE session.idsession=:id;
            
 ");        $stmt->bindParam(":id", $id,PDO::PARAM_INT);
            $stmt->bindParam(":NUM", $NUM,PDO::PARAM_INT);
            $stmt->bindParam(":venue_id", $venue_id,PDO::PARAM_INT);
            $stmt->bindParam(":venue_name", $venue_name,PDO::PARAM_STR);

            $stmt->execute();         
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
    //GetReg.
    function update_session_user($user_id,$value,$old_value){
        try{
            $stmt = $this->dbh->prepare(" 
            UPDATE attendee_session
            SET session = :value
            where attendee = :user_id AND session = :old_value
 ");
            $stmt->execute(["value"=>$value,"user_id"=> $user_id,"old_value"=>$old_value]);
         

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
    function get_venue_id($id){
      
        try{
            $stmt = $this->dbh->prepare(" 
            select event.venue
            from event 
            where event.idevent=:id");
            $stmt->execute(["id"=>$id]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
             return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return false;
       }
    } //Check if User Exits in DB.

    //GetReg.


    
///ADMIN ____FUNCTIONS ___HERE
    function getEvent(){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select *
             from event
             INNER JOIN venue ON venue.idvenue=event.venue
           ");

            $stmt->execute();

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//getPerson

    function getVenue(){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select * from venue
           ");

            $stmt->execute();

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//getPerson
    function delete_venue($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("
            delete from venue
            where venue.idvenue = :id;
            delete from event
            where event.venue = :id;
            ");
            $stmt->execute(["id"=>$id]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    function get_sessions(){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select * from session");

            $stmt->execute();

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//getPerson
 
    function get_users(){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select attendee.idattendee,attendee.name,role.name as role_name,attendee.role as role_id
            from attendee
            INNER JOIN role ON attendee.role= role.idrole");

            $stmt->execute();

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//getPerson
    function delete_admin($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("
            delete from attendee
            where attendee.idattendee = :id;
            delete from attendee_session
            where attendee_session.attendee = :id;
            delete from attendee_event
            where attendee_event.attendee = :id;
            ");
            $stmt->execute(["id"=>$id]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    function delete_event($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("
            delete from event
            where event.idevent = :id;
            
            delete from session
            where session.event = :id;
            
            delete from attendee_event
            where attendee_event.event = :id;

            delete from manager_event
            where manager_event.event = :id;

            ");
            

            $stmt->execute(["id"=>$id]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
    function update_session($event){
        try{
            $stmt = $this->dbh->prepare(
            " select session.name, session.idsession
            from session
            INNER JOIN event ON session.event = event.idevent
            where event.idevent= :event ");
            $stmt->execute(array(":event"=>$event));
         
            while($row = $stmt->fetch()){
             
               $data[]=$row;
                
            }
            return $data;

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }
    function delete_session($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("
            delete from session
            where session.idsession = :id;
            
            delete from attendee_session
            where attendee_session.session= :id;

            ");
            

            $stmt->execute(["id"=>$id]);
         
            while($row = $stmt->fetch()){
             
                return $row;
                
            }
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    function reg_usr($id,$usr_reg_event,$session){
        try{
            $stmt = $this->dbh->prepare(" 
            INSERT INTO attendee_session
            value($session,$id);
            INSERT INTO attendee_event
            values($usr_reg_event,$id,51);
           
 ");
            $stmt->execute(["session"=>$session,"usr_reg_event"=> $usr_reg_event,"id"=>$id]);
         

       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    //GetReg.

    
    function getAllObjects(){
        try{
            $data = array();
            include "./Person.class.php";
            $stmt = $this->dbh->prepare("select * from attendee");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS,"attendee");
            while($attendee = $stmt->fetch()){
                $data[] = $attendee;
            }
            return $data;
       }catch(PDOException $pe){
          echo $pe->getMessage();
          return array();
      }
    }

    ///<-------MANAGER _FUNCTIONS ____________STARTS HERE------>
    function get_users_manager($id){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select attendee.idattendee,attendee.name,role.name as role_name,attendee.role as role_id
            from attendee
            INNER JOIN role ON attendee.role= role.idrole
            INNER JOIN attendee_event ON attendee_event.attendee=attendee.idattendee
            INNER JOIN manager_event ON attendee_event.event=manager_event.event

            WHERE manager_event.manager=:id AND attendee.role<>1");

            $stmt->execute(["id"=>$id]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.

    function get_event_manager($id){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select event.idevent,event.name,event.datestart,event.dateend,event.numberallowed,event.venue
            from event
            INNER JOIN manager_event ON event.idevent= manager_event.event
            WHERE manager_event.manager=:id;");

            $stmt->execute(["id"=>$id]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.

   

    function get_session_manager($id){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("select session.event,session.idsession,session.name,session.startdate,session.enddate,session.numberallowed
            from session
            INNER JOIN manager_event ON session.event= manager_event.event
             WHERE manager_event.manager=:id;");
            $stmt->execute(["id"=>$id]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.

    function add_admin_session($id,$name,$start,$end,$num,$event){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("
            INSERT INTO session (idsession,name,numberallowed,event,startdate,enddate)
            values(:id,:name,:num,:event,:srt,:end)");
            $stmt->execute(["id"=>$id,"name"=>$name,"srt"=>$start,"end"=>$end,"num"=>$num,"event"=>$event]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.
    function add_admin_event($id,$name,$start,$end,$num,$venue){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("
            INSERT INTO event (idevent,name,numberallowed,venue,datestart,dateend)
            values(:id,:name,:num,:venue,:srt,:end)");
            $stmt->execute(["id"=>$id,"name"=>$name,"srt"=>$start,"end"=>$end,"num"=>$num,"venue"=>$venue]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.
    function add_admin_user($id,$paid,$session,$event){
        $data = array();
        try{
            $stmt = $this->dbh->prepare("
            INSERT INTO attendee_session
            values (:session,:id);
            INSERT INTO attendee_event
            values (:event,:id,:paid)");
            $stmt->execute(["id"=>$id,"session"=>$session,"paid"=>$paid,"event"=>$event]);

            while($row = $stmt->fetch()){
                $data[] = $row;
            }
            return $data;

        }catch(PDOException $pe){
           echo $pe->getMessage();
           return $data;
       }
    }//get User Manager.

   


}
