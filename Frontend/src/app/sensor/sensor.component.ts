import { Component, OnInit } from '@angular/core';

import { FormGroup, FormBuilder, FormArray, FormControl, Validators } from '@angular/forms';

import { SharedDataService, UserService } from '../_services';
import { SensorAddModel } from '../_modelsIot';

@Component({
  selector: 'app-sensor',
  templateUrl: './sensor.component.html',
  styleUrls: ['./sensor.component.css']
})
export class SensorComponent implements OnInit {

  successAdd: boolean = null;
  successSearch: boolean = null;
  sensorForm: FormGroup;
  plants: any;

  constructor(
    private fb: FormBuilder,
    private shared: SharedDataService,
    private userService: UserService
  ) { }

  ngOnInit() {

    this.plants = this.shared.plantsAdmin;

    this.sensorForm = this.fb.group({
      'Marca': ['', Validators.required],
      'Typology': ['', Validators.required],
      'Plant': ['', Validators.required],

    })

  }

  insertSensor(model: any, isValid: boolean) {

    this.successAdd = null;

    let plantId: number;

    let obj: SensorAddModel;
    obj = new SensorAddModel();

    for (let i = 0; i < this.shared.plantsAdmin.length; i++) {

      if (model.Plant == this.shared.plantsAdmin[i].Nome) {

        plantId = +this.shared.plantsAdmin[i].Id;

      }
    }

    obj.Tipo = model.Typology;
    obj.Marca = model.Marca;
    obj.ImpiantoId = plantId;
    obj.Stato = 1;

    this.userService.addSensor(obj).subscribe(
      data => {

        if (data.Value == true) {
          this.successAdd = true;
        }

        if (data.Value == false) {
          this.successAdd = false;
        }
      })

  }

  search() {
    this.successSearch = false;
  }


}
