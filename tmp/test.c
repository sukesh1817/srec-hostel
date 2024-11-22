#include <stdio.h>
#include <string.h>
#include <stdlib.h>


struct user_details_t {
    char name[50];
    int age;
    long int mobile_number;
    int class;
    int pos;
    struct user_details_t * nxt;
   
};
void show_seats_avaliability(struct user_details_t *temp) {
    
    printf("SEATS AVALIABILITY : ");
    if(temp == NULL) {
        printf("ALL SEATS ARE AVALIABLE\n");
    } else {
    printf("* -> THESE SEATS ARE BOOKED\n");
    int f_class[10]={0};
    int s_class[10]={0};
    int t_class[10]={0};
    // int f = 0;
    // int s = 0;
    // int t = 0;
    while(temp != NULL) {
        if(temp->class == 1) {
            f_class[temp->pos-1] = temp->pos;
            // f++;
        }
        else if(temp->class == 2) {
            s_class[temp->pos-1] = temp->pos;
            // s++;
        }
        else if(temp->class == 3) {
            t_class[temp->pos-1] = temp->pos;
            // t++;
        }
        temp = temp->nxt;
        // printf("class : %d,", temp->pos);
        // temp = temp->nxt;
        
    }
    printf("\nAVALIABLE SEATS IN CLASS 1 : ");
    for(int i=0;i<sizeof(f_class)/sizeof(f_class[0]);i++) {
       if(f_class[i] == 0) {
           printf("%d ",i+1);
       } else {
           printf("* ");
       }
        
    }
    printf("\nAVALIABLE SEATS IN CLASS 2 : ");
    for(int i=0;i<sizeof(s_class)/sizeof(s_class[0]);i++) {
      if(s_class[i] == 0) {
           printf("%d ",i+1);
       } else {
           printf("* ");
       }
        
    }
    printf("\nAVALIABLE SEATS IN CLASS 3 : ");
     for(int i=0;i<sizeof(t_class)/sizeof(t_class[0]);i++) {
       if(t_class[i] == 0) {
           printf("%d ",i+1);
       } else {
           printf("* ");
       }
        
    }
    
    }
    printf("\n");
}
void book_ticket(struct user_details_t **q, struct user_details_t u) {
    struct user_details_t * temp = (struct user_details_t *) malloc(sizeof(struct user_details_t));
    struct user_details_t * prev = (struct user_details_t *) malloc(sizeof(struct user_details_t));
    
    strcpy(temp->name, u.name);
    temp->age = u.age;
    temp->mobile_number = u.mobile_number;
    temp->class = u.class;
    temp->pos = u.pos;
    temp->nxt =NULL;
    
    
    prev = (*q);
    
    if((*q) == NULL) {
        (*q) = temp;
    } else {
        while((*q)->nxt != NULL) {
            (*q) = (*q)->nxt;
        }
        (*q)->nxt = temp;
        
        printf("inserted pos : %d\n",(*q)->pos);
        
        (*q) = prev;
    }
    
    
    printf("\n");
   
}

void cancel_ticket(struct user_details_t **q, int pos, int class) {
    struct user_details_t * temp = (struct user_details_t *) malloc(sizeof(struct user_details_t));
    struct user_details_t * prev = (struct user_details_t *) malloc(sizeof(struct user_details_t));
    struct user_details_t * prev_2 = (struct user_details_t *) malloc(sizeof(struct user_details_t));
    char sure[10];
    prev = (*q);
    
     if((*q) == NULL) {
        printf("NOTHING OF THE SEAT IS BOOKED\n");
    } else {
         while((*q)->nxt != NULL) {
            if((*q)->pos == pos && (*q)->class == class) {
                temp = (*q);
                printf("Are you sure to delete ? Yes/No\n");
                scanf("%s", sure);
                if(strcmp(sure,"Yes") == 0) {
                    prev_2->nxt = (*q)->nxt;
                    printf("Seat at class %d and pos %d successfully deleted !\n",temp->class, temp->pos);
                    free(temp);
                } else {
                    break;
                }
                
            }
            prev_2 = (*q);
            (*q) = (*q)->nxt;
        }
    }
}
int main()
{
    int f = 10;
    int s = 10;
    int t = 10;
    int c = 1;
    struct user_details_t u;
    struct user_details_t *head = NULL;

    
    do {
        printf("---------------------------------------\n");
        printf("Press 1 For Seat booking\n");
        printf("Press 2 For View Total avaliable seats\n");
        printf("Press 3 For Cancel booking\n");
        printf("Press 4 For Exit\n");
        printf("Enter Here : ");
        scanf("%d", &c);
        while(!(c>0) && !(c<5)) {
            printf("!!!Invalid choice!!!\n");
            printf("Enter Here : ");
            scanf("%d", &c);
        }
         
        if(c == 1) {
            // printf("addr is %p\n",&head);

            show_seats_avaliability(head);
            printf("Enter the name : ");
            scanf("%s", u.name);
            printf("Enter the age : ");
            scanf("%d", &u.age);
            printf("Enter the mobile : ");
            scanf("%ld", &u.mobile_number);
            printf("Enter the class : ");
            scanf("%d", &u.class);
            printf("Enter the pos : ");
            scanf("%d", &u.pos);
            book_ticket(&head,u);
            // printf("addr is %p\n",&head);
            
        } else if(c == 2) {
            // Total avaliable seats.
            show_seats_avaliability(head);
        } else if(c == 3) {
            if(head == NULL) {
                printf("NOTHING OF THE SEAT IS BOOKED\n");
                continue;
            }
            int pos;
            int class;
            printf("Enter the class to cancel ticket : ");
            scanf("%d", &class);
            printf("Enter the class to postion  : ");
            scanf("%d", &pos);
            cancel_ticket(&head, pos, class);
        } 
       
        
    } while(c != 4);
    return 0;
}