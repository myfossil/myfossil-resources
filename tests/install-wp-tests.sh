#!/usr/bin/env bash
DB_NAME=${1-wp_myfossil_test}
DB_USER=${2-wp_myfossil}
DB_PASS=${3-wp_myfossil}
DB_HOST=${4-0.0.0.0:13306}
WP_VERSION=latest
WP_TESTS_DIR=${WP_TESTS_DIR-/tmp/wordpress-tests-lib}
WP_CORE_DIR=/tmp/wordpress/

set -ex

install_wp() {
	mkdir -p $WP_CORE_DIR

	if [ $WP_VERSION == 'latest' ]; then 
		local ARCHIVE_NAME='latest'
	else
		local ARCHIVE_NAME="wordpress-$WP_VERSION"
	fi

	wget -nv -O /tmp/wordpress.tar.gz http://wordpress.org/${ARCHIVE_NAME}.tar.gz
	tar --strip-components=1 -zxmf /tmp/wordpress.tar.gz -C $WP_CORE_DIR

	wget -nv -O $WP_CORE_DIR/wp-content/db.php https://raw.github.com/markoheijnen/wp-mysqli/master/db.php
}

install_test_suite() {
	# set up testing suite
	mkdir -p $WP_TESTS_DIR
	cd $WP_TESTS_DIR
	svn co --quiet http://develop.svn.wordpress.org/trunk/tests/phpunit/includes/

	wget -nv -O wp-tests-config.php http://develop.svn.wordpress.org/trunk/wp-tests-config-sample.php
	sed -i "s:dirname( __FILE__ ) . '/src/':'$WP_CORE_DIR':" wp-tests-config.php
	sed -i "s/youremptytestdbnamehere/$DB_NAME/" wp-tests-config.php
	sed -i "s/yourusernamehere/$DB_USER/" wp-tests-config.php
	sed -i "s/yourpasswordhere/$DB_PASS/" wp-tests-config.php
	sed -i "s|localhost|${DB_HOST}|" wp-tests-config.php
}

install_db() {
	# parse DB_HOST for port or socket references
	local PARTS=(${DB_HOST//\:/ })
	local DB_HOSTNAME=${PARTS[0]};
	local DB_SOCK_OR_PORT=${PARTS[1]};
	local EXTRA=""

	if ! [ -z $DB_HOSTNAME ] ; then
		if [[ "$DB_SOCK_OR_PORT" =~ ^[0-9]+$ ]] ; then
			EXTRA=" --host=$DB_HOSTNAME --port=$DB_SOCK_OR_PORT --protocol=tcp"
		elif ! [ -z $DB_SOCK_OR_PORT ] ; then
			EXTRA=" --socket=$DB_SOCK_OR_PORT"
		elif ! [ -z $DB_HOSTNAME ] ; then
			EXTRA=" --host=$DB_HOSTNAME --protocol=tcp"
		fi
	fi

	# create database
	mysqladmin create $DB_NAME --user="$DB_USER" --password="$DB_PASS"$EXTRA
}

install_wp
install_test_suite
install_db
