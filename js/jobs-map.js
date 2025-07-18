function JobsMap(mapId) {
    this.googleMap = null;
    this.markerCluster = null;
    this.allJobs = {};
    this.currentMarkerOnMap = {};
    this.contentStrings = {};
    this.infoWindows = {};

    this.defaultMapPosition = {lat: 50.253850, lng: 8.641741};
    this.defaultMapId = 'map';
    this.defaultMapZoom = 5;
    this.defaultKeyColor = '#20A8D8';
    this.defaultSecoundaryColor = '#ffffff';
    this.defaultMapStyle = [
        {
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": this.defaultKeyColor
                },
                {
                    "saturation": 36
                },
                {
                    "lightness": 40
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": this.defaultSecoundaryColor
                },
                {
                    "lightness": 16
                },
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#fefefe"
                },
                {
                    "lightness": 20
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#fefefe"
                },
                {
                    "lightness": 17
                },
                {
                    "weight": 1.2
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#427091"
                },
                {
                    "visibility": "on"
                },
                {
                    "weight": 0.5
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#eef0f7"
                },
                {
                    "lightness": 20
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#427091"
                },
                {
                    "lightness": 21
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dedede"
                },
                {
                    "lightness": 21
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "lightness": 18
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "lightness": 17
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "lightness": 29
                },
                {
                    "weight": 0.2
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "lightness": 16
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f2f2f2"
                },
                {
                    "lightness": 19
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e9e9e9"
                },
                {
                    "lightness": 17
                }
            ]
        }
    ];

    this.init = function (mapId) {

        var id = typeof mapId !== 'undefined' && mapId !== null ? mapId : this.defaultMapId;

        this.setKeyColors();
        this.setMapStyle();

        if (document.getElementById(id)) {
            this.googleMap = new google.maps.Map(document.getElementById(id), {
                zoom: this.defaultMapZoom,
                center: this.defaultMapPosition,
                styles: this.defaultMapStyle
            });

            this.setAllJobMarkers();
        }
    };

    this.setKeyColors = function () {
        var keyColor = document.querySelector('body').dataset.keyColor;

        if (typeof keyColor !== 'undefined' && keyColor !== null) {
            this.defaultKeyColor = keyColor.replace(' ', '');
        }
    };

    this.setMapStyle = function () {
        var mapStyle = document.querySelector('body').dataset.mapStyle;

        if (typeof mapStyle !== 'undefined' && mapStyle !== null) {
            this.defaultMapStyle = JSON.parse(mapStyle);
        } else {
            this.defaultMapStyle[1]['stylers'][0]['color'] = this.defaultKeyColor;
        }
    };

    this.setAllJobMarkers = function (searchParams = null) {

        var _this = this;

        var queryParams = searchParams !== null ? searchParams : templateHandler.getQueryParams();
        this.getJobData(queryParams, function (data) {
            _this.allJobs = data.jobs;
            _this.createMarkersFromJobs(data.jobs, true)
        });
    };

    this.getJobData = function (searchParams, callback) {
        var url = typeof searchParams !== 'undefined' && searchParams != null
            ? '../../partials/get_jobs_json.php' + searchParams
            : '../../partials/get_jobs_json.php';

        templateHandler.ajaxCall(url, {}, true, function (result) {

            if (result.status_code === 200) {
                if (typeof callback !== 'undefined') {
                    callback(result.response.data);
                }
            }
        });
    };

    this.createMarkersFromJobs = function (jobs, cluster) {
        var _this = this;
        var setCluster = typeof cluster !== 'undefined' ? cluster : false;

        $.each(jobs, function (key, value) {

            if (!templateHandler.empty(value.company_location_jobs)) {

                $.each(value.company_location_jobs, function (k, v) {

                    if (
                        !templateHandler.inArray(v.company_location.id, Object.keys(_this.currentMarkerOnMap)) &&
                        !templateHandler.empty(v.company_location.lat) &&
                        !templateHandler.empty(v.company_location.lng)
                    ) {

                        var contentString = v.company_location.city;

                        if (!templateHandler.empty(v.company_location.street)) {
                            contentString += ', ' + v.company_location.street;
                        }

                        if (!templateHandler.empty(v.company_location.street_number)) {
                            contentString += ' ' + v.company_location.street_number;
                        }

                        _this.contentStrings[v.company_location.id] = contentString;

                        var infoWindow = new google.maps.InfoWindow({
                            content: _this.contentStrings[v.company_location.id]
                        });

                        google.maps.event.addListener(infoWindow, 'closeclick', function () {
                            if (typeof templateHandler !== 'undefined' && typeof templateHandler.filter !== 'undefined') {
                                $('#standort').val('');
                                $('#location-list').val('all');
                                templateHandler.filter();
                            }
                        });

                        _this.infoWindows[v.company_location.id] = infoWindow;

                        var markerLatLng = {
                            lat: parseFloat(v.company_location.lat),
                            lng: parseFloat(v.company_location.lng)
                        };


                        var marker = new google.maps.Marker({
                            position: markerLatLng,
                            title: value.job_strings[0].title,
                            icon: new google.maps.MarkerImage(_this.getGoogleMarkerInlineSvg(_this.defaultKeyColor), null, null, null, new google.maps.Size(40, 30)),
                        });

                        marker.addListener('click', function (e) {

                            $.each(_this.infoWindows, function (key, value) {
                                value.close();
                            });

                            _this.infoWindows[v.company_location.id].open(_this.googleMap, marker);
                            if (typeof templateHandler !== 'undefined' && typeof templateHandler.filter !== 'undefined') {

                                templateHandler.filter({
                                    searchType: 'getjobsByCompanyLocationId',
                                    company_location_id: v.company_location_id,
                                    full_address: v.company_location?.full_address,
                                }, null, null, null);
                            }

                        }.bind(_this));

                        marker.setMap(_this.googleMap);

                        _this.currentMarkerOnMap[v.company_location.id] = marker;
                    }
                });
            }
        });

        // Add a marker clusterer to manage the markers.
        if (typeof MarkerClusterer !== 'undefined' && setCluster) {
            if (this.markerCluster !== null) {
                this.markerCluster.clearMarkers();
            }

            var cluster_styles = [
                {
                    width: 40,
                    height: 40,
                    url: this.getGoogleClusterInlineSvg(this.defaultKeyColor),
                    textColor: 'white',
                    textSize: 12
                },
                {
                    width: 50,
                    height: 50,
                    url: this.getGoogleClusterInlineSvg(this.defaultKeyColor),
                    textColor: 'white',
                    textSize: 14
                },
                {
                    width: 60,
                    height: 60,
                    url: this.getGoogleClusterInlineSvg(this.defaultKeyColor),
                    textColor: 'white',
                    textSize: 16
                }
                //up to 5
            ];

            this.markerCluster = new MarkerClusterer(this.googleMap, this.currentMarkerOnMap,
                {styles: cluster_styles}
            );
        }

    };

    this.unsetMarkers = function (keepAliveCompanyLocationIds) {

        var _this = this;

        $.each(this.allJobs, function (key, value) {
            $.each(value.company_location_jobs, function (k, v) {
                if (
                    !templateHandler.inArray(v.company_location.id, keepAliveCompanyLocationIds) &&
                    templateHandler.inArray(v.company_location.id, Object.keys(_this.currentMarkerOnMap))
                ) {
                    _this.currentMarkerOnMap[v.company_location.id].setMap(null);
                    delete _this.currentMarkerOnMap[v.company_location.id];
                }
            });
        });
    };

    this.getGoogleMarkerInlineSvg = function (color) {
        var encoded = window.btoa(
            '<svg id="Ebene_1" data-name="Ebene 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.06 11.77">' +
            '<defs>' +
            '<style>.cls-1{fill:' + color + ';}</style>' +
            '</defs>' +
            '<title>map_pin_map_icon</title>' +
            '<path class="cls-1" d="M8.59,1.47A5,5,0,0,0,1.47,8.59l2.92,2.92a.92.92,0,0,0,1.29,0L8.59,8.59A5,5,0,0,0,8.59,1.47Zm-5.15,2a2.26,2.26,0,1,1,0,3.19A2.24,2.24,0,0,1,3.44,3.44Z"/>' +
            '</svg>'
        );

        return ('data:image/svg+xml;base64,' + encoded);
    };

    this.getGoogleClusterInlineSvg = function (color) {
        var encoded = window.btoa(
            '<svg id="Ebene_1" data-name="Ebene 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.06 10.06">' +
            '<defs>' +
            '<style>.cls-1,.cls-2{fill:' + color + ';}.cls-1{opacity:0.5;}</style>' +
            '</defs>' +
            '<title>map_pin_cluster_icon_small</title>' +
            '<circle class="cls-1" cx="5.03" cy="5.03" r="5.03"/>' +
            '<circle class="cls-2" cx="5.03" cy="5.03" r="3.87"/>' +
            '</svg>'
        );

        return ('data:image/svg+xml;base64,' + encoded);
    };

    this.init(mapId);
};

var jobsMap = null;
$(document).ready(function () {
    jobsMap = new JobsMap('map');
});
