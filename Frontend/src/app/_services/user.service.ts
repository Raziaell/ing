import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { ReplaySubject } from 'rxjs/ReplaySubject';
import 'rxjs/add/operator/map'
import 'rxjs/add/operator/catch';

import { ApiService } from './api.service';
import { ILoginModel } from '../_models';
import { IotUserModel } from '../_modelsIot';

@Injectable()
export class UserService {

    constructor(
        private apiService: ApiService,
        private http: Http,
    ) { }

    //Nuovi metodi IoTAndria

    loginIot(user: ILoginModel): Observable<any> {
        return this.apiService.post('/login', user)
            .map(data => {
                return data;
            });
    }

    getId(user: ILoginModel): Observable<any> {
        return this.apiService.post('/idGet', user)
            .map(data => {
                return data;
            });
    }

    getImpianti(user: IotUserModel): Observable<any> {
        return this.apiService.post('/impiantoGet', user)
            .map(data => {
                return data;
            });
    }

    getAllImpianti(): Observable<any> {
        return this.apiService.postNotArray('/impiantoGet')
            .map(data => {
                return data
            })
    
    }

    getDetections(id: any): Observable<any> {
        return this.apiService.post('/getDetectionByPlant', id)
            .map(data => {
                return data;
            })
    }

    postThirdActor(obj: any): Observable<any> {
        return this.apiService.postNotArray('/createThirdParty', obj)
            .map(data => {
                return data
            })
    }

    addAdmin(obj: any): Observable<any> {
        return this.apiService.post('/amministratorePost', obj)
            .map(data => {
                return data
            })
    }

    addStandard(obj: any): Observable<any> {
        return this.apiService.post('/clientePost', obj)
            .map(data => {
                return data
            })

    }

    getAllStandard(): Observable<any> {
        return this.apiService.postNotArray('/clienteGet')
            .map(data => {
                return data
            })
    }

    addPlant(obj: any): Observable<any> {
        return this.apiService.post('/impiantoPost', obj)
            .map(data => {
                return data
            })

    }

    addSensor(obj: any): Observable<any> {
        return this.apiService.post('/sensorePost', obj)
            .map(data => {
                return data
            })
    }


}