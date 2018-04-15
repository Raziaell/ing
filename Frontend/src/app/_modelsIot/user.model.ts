export class IotUserModel {
    
    username: string;
    password: string;
    isAdmin: boolean;

}

export class AdminModel {

    Username: string;
    Password: string;
    Ruolo: string;
    Nome: string;
    Cognome: string;
    CodiceFiscale: string;

}

export class StandardModel {

    Username: string;
    Password: string;
    Ruolo: string;
    P_IVA: string;
    Nome: string;
    Citta: string;
    
}

export class StandardGetModel {

    Username: string;
    Citta: string;
    P_IVA: string;
    Nome: string;
    Id: string;
}