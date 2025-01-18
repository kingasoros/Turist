import React, { useEffect, useState } from 'react';
import { View, Text, Button, StyleSheet, Alert, Image, TouchableOpacity } from 'react-native';
import { useNavigation } from '@react-navigation/native';

const ProfileScreen = () => {
  const [userName, setUserName] = useState('');
  const navigation = useNavigation();

  useEffect(() => {
    fetch('http://192.168.1.6/Turist/Turist_MobilApp/screens/get_user_name.php', {
      method: 'GET',
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          setUserName(data.user_name); 
        } else {
          Alert.alert('Hiba', 'Nem sikerült lekérni a felhasználó nevét.');
        }
      })
      .catch(error => {
        console.error(error);
        Alert.alert('Hiba', 'Hiba történt a session lekérése közben.');
      });
  }, []);

  const handleLogout = () => {
    fetch('http://192.168.1.6/Turist/Turist_MobilApp/screens/logout.php', {
      method: 'POST',
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Alert.alert('Kijelentkezés', 'Sikeresen kijelentkeztél!');
          navigation.navigate('Login'); 
        } else {
          Alert.alert('Hiba', 'Nem sikerült kijelentkezni.');
        }
      })
      .catch(error => {
        console.error(error);
        Alert.alert('Hiba', 'Hiba történt a kijelentkezés közben.');
      });
  };

  return (
    <View style={styles.container}>
      <Image 
        source={{uri: 'http://192.168.1.6/Turist/img/profil.jpg'}} 
        style={styles.profileImage}
      />
      
      <View style={styles.content}>
        <Text style={styles.title}>Profil</Text>
        {userName ? (
          <Text style={styles.userName}>Üdvözlünk, {userName}!</Text>
        ) : (
          <Text style={styles.loadingText}>Betöltés...</Text>
        )}
        
        <Text style={styles.infoText}>
          Ez az alkalmazás a weboldalunk mobil verziója, amely lehetővé teszi, hogy könnyedén megtekinthesd a város legszebb látványosságait. 
          Nyomon követheted kedvenc és privát túráidat, miközben a hozzájuk tartozó térképeket is megjelenítjük számodra. 
          Használatával még egyszerűbbé válik a felfedezés és a tervezés!
        </Text>

        <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
          <Text style={styles.logoutButtonText}>Kijelentkezés</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  profileImage: {
    width: '100%',
    height: 250,  
    position: 'absolute', 
    top: 0,
    left: 0,
    zIndex: 1, 
  },
  content: {
    flex: 1,
    justifyContent: 'flex-start',
    alignItems: 'center',
    marginTop: 230,  
    paddingHorizontal: 16,
  },
  title: {
    fontSize: 30,
    fontWeight: 'bold',
    color: '#3b5147',
    marginBottom: 20,
    marginTop: 30,
  },
  userName: {
    fontSize: 22,
    color: '#3b5147',
    marginBottom: 20,
  },
  loadingText: {
    fontSize: 18,
    color: '#aaa',
    marginBottom: 20,
  },
  infoText: {
    fontSize: 16,
    color: '#3b5147',
    textAlign: 'center',
    marginBottom: 30,
    paddingHorizontal: 20,
  },
  logoutButton: {
    backgroundColor: '#f00',
    paddingVertical: 12,
    paddingHorizontal: 30,
    borderRadius: 8,
    marginTop: 20,
  },
  logoutButtonText: {
    fontSize: 18,
    color: '#fff',
    textAlign: 'center',
  }
});

export default ProfileScreen;
