import * as React from 'react';
import { StyleSheet, View, Dimensions } from 'react-native';
import MapView from 'react-native-open-street-map';

export default class CustonMap extends React.PureComponent {
render() {
    const {
      width,
      height,
    } = Dimensions.get('window');
    const region = {
      latitude: 0,
      longitude: 0,
      latitudeDelta:  0.0922,
      longitudeDelta: 0.0922 * (width / height)
    };
    return (
      <MapView
        ref="map"
        zoom={5}
        multiTouchControls
        style={{
          flex: 1
        }}
        region={region}
        showsUserLocation
      router={{
          titleA: 'New Yourk city',
          descriptionA: 'My location',
          coordinates: [{
            latitude: parseFloat('40.7142700'),
            longitude: parseFloat('-74.0059700'),
          }],
        }}
      />
    );
  }
}

