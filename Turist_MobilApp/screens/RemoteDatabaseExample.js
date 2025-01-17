// screens/RemoteDatabaseExample.js
import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, FlatList } from 'react-native';
import axios from 'axios';

const RemoteDatabaseExample = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    axios
      .get('http://YOUR_SERVER_IP_OR_DOMAIN/get_users.php')
      .then((response) => {
        setUsers(response.data);
      })
      .catch((error) => {
        console.error('Hiba az API hívás során: ', error);
      });
  }, []);

  return (
    <View style={styles.container}>
      <Text>Felhasználók:</Text>
      <FlatList
        data={users}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <Text>{item.name} - {item.age}</Text>
        )}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default RemoteDatabaseExample;
