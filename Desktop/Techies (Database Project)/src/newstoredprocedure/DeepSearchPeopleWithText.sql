 select deep_search_people_with_text('yo',1);
 
 CREATE TABLE TEMP1_RETURN(mem_id INTEGER,matches text,associated_type INTEGER);
 
 

 create type holder as (mem_id INTEGER,matches text);

 DROP FUNCTION deep_search_people_with_text(text,integer);
 
 CREATE OR REPLACE FUNCTION deep_search_people_with_text(search_var text,own_memid integer)
 RETURNS TABLE( ID INTEGER, FNAME varchar,LNAME varchar,ASSOCIATED_TYPE INTEGER,MATCHES text) AS $$
 
 DECLARE
      searchqueryaggregate text := '';
      var_match text;
      var_mem_id integer;
      row_value holder%rowtype;
 
 BEGIN
 	CREATE TABLE TEMP1_FRIENDS_NEW(mem_id INTEGER);
 	CREATE TABLE TEMP1_FRIENDPRIVACY2(mem_id INTEGER);
 	CREATE TABLE TEMP1_FOF(mem_id INTEGER);
 	CREATE TABLE TEMP1_FOFPrivacy3(mem_id INTEGER);
 	CREATE TABLE TEMP1_RequestSent(mem_id INTEGER);
 	CREATE TABLE TEMP1_RequestReceived(mem_id INTEGER);
 	CREATE TABLE TEMP1_UNION(mem_id INTEGER,matches text);
	
 
      truncate TABLE TEMP1_FRIENDS_NEW;
      truncate TABLE TEMP1_FRIENDPRIVACY2;
      truncate TABLE TEMP1_FOF;
      truncate TABLE TEMP1_FOFPrivacy3;
      truncate TABLE TEMP1_RETURN; 
      truncate TABLE TEMP1_RequestReceived;
      truncate TABLE TEMP1_RequestSent; 
      truncate TABLE TEMP1_UNION;
    
 
 INSERT INTO TEMP1_UNION ( select mem_id ,profile_string as matches  from profile where keywords ilike '%'||search_var||'%' or profile_string ilike '%'||search_var||'%' union all
 select mem_id ,title as matches  from multimedia_details where title ilike '%'||search_var||'%' union all
 select mem_id ,comment_text as matches  from comments_board where comment_text ilike '%'||search_var||'%' union all
 select mem_id ,diary_title as matches  from diary_entry where diary_title ilike  '%'||search_var||'%' union all
 select mem_id ,text as matches  from diary_entry where diary_title ilike  '%'||search_var||'%'  union all 
 select mem_id,f_name as matches  from member_info where f_name ilike '%'||search_var||'%' union all
 select mem_id,m_name as matches  from member_info where m_name ilike '%'||search_var||'%' union all
 select mem_id,l_name as matches  from member_info where l_name ilike '%'||search_var||'%' union all
 select mem_id,email_id as matches  from member_info where email_id ilike '%'||search_var||'%' union all
 select mem_id,phone_no as matches  from member_info where phone_no ilike '%'||search_var||'%' union all
 select mem_id,line1 as matches  from member_info where line1 ilike '%'||search_var||'%' union all
 select mem_id,line2 as matches  from member_info where line2 ilike '%'||search_var||'%' union all
 select mem_id,state as matches  from member_info where state ilike '%'||search_var||'%' union all
 select mem_id,city as matches  from member_info where city ilike '%'||search_var||'%' union all
 select mem_id,country as matches  from member_info where country ilike '%'||search_var||'%' union all
 select mem_id,zip_code as matches  from member_info where zip_code ilike '%'||search_var||'%');


 	INSERT into TEMP1_FRIENDS_NEW (select mem_id_1 as mem_id from friendship_status where mem_id_2=own_memid and rel_code=2 union select mem_id_2 as mem_id from friendship_status where mem_id_1=own_memid and rel_code=2);
        INSERT into TEMP1_FRIENDPRIVACY2 (select T.mem_id  from TEMP1_FRIENDS_NEW T,account_privacy ap where T.mem_id = ap.mem_id and ap.privacy_code >= '2');
        INSERT into TEMP1_FOF(select mem_id from profile where mem_id in (select mem_id_2 from friendship_status where mem_id_1 in (select mem_id_1 as friends from friendship_status where mem_id_2=own_memid and rel_code=2 union select

mem_id_2 as friends from friendship_status where mem_id_1=own_memid and rel_code=2 )and mem_id_2 <> own_memid and rel_code=2 union select mem_id_1 from friendship_status where mem_id_2 in (select mem_id_1 as friends from friendship_status where

mem_id_2=own_memid and rel_code=2 union select mem_id_2 as friends from friendship_status where mem_id_1=own_memid and rel_code=2 )and mem_id_1 <> own_memid and rel_code=2 ));
	INSERT into TEMP1_FOFPrivacy3(select TF.mem_id  from TEMP1_FOF TF,account_privacy ap where TF.mem_id = ap.mem_id and ap.privacy_code >= '3');
	Insert into TEMP1_RequestReceived(select mem_id_1 as friends from friendship_status where mem_id_2=own_memid and rel_code=1 and initiator <> own_memid union select mem_id_2 as friends from friendship_status where mem_id_1=own_memid and rel_code=1 and initiator <> own_memid);
        Insert into TEMP1_RequestSent(select mem_id_1 as friends from friendship_status where mem_id_2=own_memid and rel_code=1 and initiator = own_memid union select mem_id_2 as friends from friendship_status where mem_id_1=own_memid and rel_code=1 and initiator = own_memid);
      
 FOR row_value IN (select mem_id,array_to_string(array_agg(TEMP1_UNION.matches),';')as matches from TEMP1_UNION group by mem_id order by mem_id) LOOP
        var_mem_id = row_value.mem_id;
        var_match =  row_value.matches;

        IF var_mem_id <> own_memid THEN
     			IF var_mem_id NOT IN (Select mem_id from TEMP1_FRIENDPRIVACY2) and var_mem_id NOT IN (Select mem_id from TEMP1_FOFPrivacy3) THEN 
		           IF var_mem_id IN (Select mem_id from TEMP1_RequestReceived) THEN INSERT into TEMP1_RETURN Values (var_mem_id,var_match,1);
		           ELSIF var_mem_id IN (Select mem_id from TEMP1_RequestSent) THEN INSERT into TEMP1_RETURN Values (var_mem_id,var_match,2);
		           ELSE INSERT into TEMP1_RETURN Values (var_mem_id,var_match,3);
		           END IF;
			ELSIF var_mem_id NOT IN (Select mem_id from TEMP1_FRIENDPRIVACY2) and var_mem_id IN (Select mem_id from TEMP1_FOFPrivacy3) THEN 
		            IF var_mem_id IN (Select mem_id from TEMP1_RequestReceived) THEN INSERT into TEMP1_RETURN Values (var_mem_id,var_match,1); 
		            ELSIF var_mem_id IN (Select mem_id from TEMP1_RequestSent)  THEN INSERT into TEMP1_RETURN Values (var_mem_id,var_match,2);
		            ELSE INSERT into TEMP1_RETURN Values (var_mem_id,var_match,4);
		            END IF;
		        
		        ELSIF var_mem_id IN (Select mem_id from TEMP1_FRIENDPRIVACY2) THEN INSERT into TEMP1_RETURN Values (var_mem_id,var_match,5);
		        ELSE  INSERT into TEMP1_RETURN Values (var_mem_id,var_match,6);
		        END IF;
	END IF;	        
    END LOOP;
      
	DROP TABLE TEMP1_FRIENDS_NEW;
	DROP  TABLE TEMP1_FRIENDPRIVACY2;
	DROP  TABLE TEMP1_FOF;
	DROP  TABLE TEMP1_FOFPrivacy3;
	DROP TABLE TEMP1_RequestReceived;
	DROP TABLE TEMP1_RequestSent;
	DROP TABLE TEMP1_UNION;
       
    RETURN QUERY(select m.mem_id,m.f_name,m.l_name,t.associated_type,t.matches from TEMP1_RETURN t,member_info m where t.mem_id=m.mem_id);
END;
$$ language plpgsql;