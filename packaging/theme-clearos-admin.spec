Name: theme-clearos-admin
Group: Applications/Themes
<<<<<<< HEAD
Version: 7.1.16
=======
Version: 7.1.15
>>>>>>> ef1ff31e911c7d14466e31a5c2294bc93cdb706c
Release: 1%{dist}
Summary: ClearOS 7 base theme
License: ClearCenter license
Packager: ClearCenter
Vendor: ClearCenter
Source: %{name}-%{version}.tar.gz
Requires: clearos-framework >= 7.1.6
Buildarch: noarch

%description
ClearOS Admin Theme

%prep
%setup -q
%build

%install
mkdir -p -m 755 $RPM_BUILD_ROOT/usr/clearos/themes/ClearOS-Admin
cp -r * $RPM_BUILD_ROOT/usr/clearos/themes/ClearOS-Admin

%files
%defattr(-,root,root)
%dir /usr/clearos/themes/ClearOS-Admin
/usr/clearos/themes/ClearOS-Admin
