#!/bin/sh
#EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
#Copyright (C) 2015 Jonas Fischer

#This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
#This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
#You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

mkdir -p /var/log/ecp
chown -R www-data /var/log/ecp
chmod -R 644 /var/log/ecp

cp ./cron /etc/cron.d/ecp
chown root /etc/cron.d/ecp
chmod 644 /etc/cron.d/ecp