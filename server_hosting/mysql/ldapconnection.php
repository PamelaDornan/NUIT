		<?php
		$LDAPHOST = "directory.northwestern.edu";    # LDAP server domain name
		$LDAPPORT = 389;                               # LDAP server port
		$ldapconn = ldap_connect( $LDAPHOST, $LDAPPORT ) or die ("Could not connect to {$LDAPHOST}" );
		if ($ldapconn){
			# Anonymously bind to the server
			$r=ldap_bind($ldapconn);
			# Perform a search on the uid field NETID
			$dn = "dc=northwestern,dc=edu";
			$filter = "(|(uid=$NETID))";
			$sr=ldap_search ($ldapconn, $dn, $filter);
			$info = ldap_get_entries($ldapconn, $sr);
			$LDAPALL = "";
			for ($i=0; $i<$info["count"]; $i++) {
				for ($attribute = 0; $attribute < $info[$i]['count']; $attribute++) {
					$data = $info[$i][$attribute];
					$LDAPALL .= $data.":  ".$info[$i][$data][0]."\n";
				}
				$LDAPMail = $info[$i]["mail"][0];
				$LDAPName = $info[$i]["displayname"][0];
			}
			
		}
		ldap_close($ldapconn); ?>
