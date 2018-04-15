import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, FormArray, FormControl, Validators } from '@angular/forms';

import { SharedDataService, UserService } from '../_services';
import { StandardGetModel, PlantAddModel } from '../_modelsIot';

@Component({
  selector: 'app-plant',
  templateUrl: './plant.component.html',
  styleUrls: ['./plant.component.css']
})
export class PlantComponent implements OnInit {

  successAdd: boolean = null;
  successSearch: boolean = null;
  plantForm: FormGroup;
  customers: any;

  constructor(
    private fb: FormBuilder,
    private userService: UserService,
    private shared: SharedDataService
  ) { }

  ngOnInit() {

    this.customers = this.shared.customers;

    this.plantForm = this.fb.group({
      'Name': ['', Validators.required],
      'Owner': ['', Validators.required],
    })
  }

  insertPlant(model: any, isValid: boolean) {

    this.successAdd = null;
    
    let customerId: number;

    let obj: PlantAddModel;
    obj = new PlantAddModel();

    for (let i = 0; i < this.shared.customers.length; i++) {

       console.log(this.shared.customers)
       console.log(model.Owner)

      if (model.Owner == this.shared.customers[i].Username) {

        customerId = +this.shared.customers[i].Id;

        console.log(customerId)

      }
    }

    obj.Nome = model.Name;
    obj.Latitudine = '';
    obj.Longitudine = '';
    obj.ClienteId = customerId;
    obj.Stato = 1;

    this.userService.addPlant(obj).subscribe(
      data => {

        console.log(data)

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
