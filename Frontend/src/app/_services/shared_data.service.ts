import { Injectable } from '@angular/core';

import { ILoginModel } from '../_models';
import { SensorModel, PlantModel, DetectionModel, IotUserModel } from '../_modelsIot/index';

@Injectable()
export class SharedDataService {

    isAuthenticated: boolean;
    user: ILoginModel;

    arrayTemp: number[] = [];
    arrayUmid: number[] = [];
    arrayPrec: number[] = [];
    arrayPres: number[] = [];
    arrayVent: number[] = [];
    arrayInqu: number[] = [];

    detections: any;
    plants: any;
    plantsAdmin: any;

    customers: any;

    clienteId: any;

}