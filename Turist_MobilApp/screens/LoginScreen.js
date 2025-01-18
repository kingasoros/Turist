import React, { useState } from 'react';
import { View, Text, TextInput, Button, Alert, StyleSheet } from 'react-native';

const LoginScreen = ({ navigation }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    try {
      const response = await fetch('http://192.168.1.6/Turist/Turist_MobilApp/screens/login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
      });

      const result = await response.json();

      if (result.success) {
        Alert.alert('Sikeres bejelentkezés', `Üdvözlünk, ${result.user.name}!`);
        navigation.navigate('Home');
      } else {
        Alert.alert('Hiba', result.message);
      }
    } catch (error) {
      Alert.alert('Hiba', 'Nem sikerült kapcsolódni a szerverhez.');
    }
  };

  return (
    <View style={styles.container}>
        <View style={styles.containerlogin}>
            <Text style={styles.title}>Bejelentkezés</Text>
            <TextInput
                style={styles.input}
                placeholder="E-mail"
                keyboardType="email-address"
                value={email}
                onChangeText={setEmail}
            />
            <TextInput
                style={styles.input}
                placeholder="Jelszó"
                secureTextEntry
                value={password}
                onChangeText={setPassword}
            />
            <Button title="Bejelentkezés" onPress={handleLogin} />
            
            {/* Regisztrációs információ */}
            <Text style={styles.registerText}>
              Regisztrálni csak az oldalon lehet.
            </Text>
        </View>    
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 16,
    backgroundColor:'#3b5147'
  },
  containerlogin:{
    backgroundColor:'#ffffff80',
    padding:16,
    borderRadius: 4,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 4,
    padding: 12,
    marginBottom: 16,
  },
  registerText: {
    marginTop: 12,
    textAlign: 'center',
    fontSize: 14,
    color: '#555',
  },
});

export default LoginScreen;
