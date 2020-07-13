<template>
    <v-row>
        <v-col cols="12">
            <v-card
                flat
            >
                <v-card-title>
                    Tasks manager
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="10">
                            <v-text-field
                                label="Type your task"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-select
                                label="Priority"
                            >
                            </v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
