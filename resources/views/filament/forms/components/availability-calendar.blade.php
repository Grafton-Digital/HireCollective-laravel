<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $availabilityData = $getState() ?? [];
        $uniqueId = 'calendar-' . uniqid();
    @endphp

    <div
        x-data="{
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            availability: @js($availabilityData),

            get monthYear() {
                const date = new Date(this.currentYear, this.currentMonth);
                return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            },

            get calendarDays() {
                const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);

                let firstDayOfWeek = firstDay.getDay();
                firstDayOfWeek = firstDayOfWeek === 0 ? 7 : firstDayOfWeek;

                const days = [];

                for (let i = firstDayOfWeek - 1; i > 0; i--) {
                    days.push({
                        day: prevLastDay.getDate() - i + 1,
                        date: null,
                        isCurrentMonth: false,
                        status: null
                    });
                }

                for (let i = 1; i <= lastDay.getDate(); i++) {
                    const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    days.push({
                        day: i,
                        date: dateStr,
                        isCurrentMonth: true,
                        status: this.availability[dateStr] || 'available'
                    });
                }

                const remainingDays = 35 - days.length;
                for (let i = 1; i <= remainingDays; i++) {
                    days.push({
                        day: i,
                        date: null,
                        isCurrentMonth: false,
                        status: null
                    });
                }

                return days;
            },

            toggleDate(dateStr) {
                if (!dateStr) return;
                const current = this.availability[dateStr] || 'available';
                const statuses = ['available', 'unavailable', 'confirm'];
                const nextIndex = (statuses.indexOf(current) + 1) % statuses.length;
                this.availability = { ...this.availability, [dateStr]: statuses[nextIndex] };
            },

            previousMonth() {
                if (this.currentMonth === 0) {
                    this.currentMonth = 11;
                    this.currentYear--;
                } else {
                    this.currentMonth--;
                }
            },

            nextMonth() {
                if (this.currentMonth === 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                } else {
                    this.currentMonth++;
                }
            }
        }"
        x-init="$watch('availability', value => { $wire.set('{{ $getStatePath() }}', value) })"
        id="{{ $uniqueId }}"
        style="margin-top: 1rem;"
    >
        <div style="border-radius: 0.5rem; border: 1px solid #e5e7eb; background-color: white; padding: 1rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <button
                    type="button"
                    @click="previousMonth()"
                    style="padding: 0.25rem; border-radius: 0.25rem; color: #9ca3af; border: none; background: none; cursor: pointer; transition: all 0.15s;"
                    onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#111827';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af';"
                >
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span style="font-size: 0.875rem; font-weight: 600; color: #111827;" x-text="monthYear"></span>
                <button
                    type="button"
                    @click="nextMonth()"
                    style="padding: 0.25rem; border-radius: 0.25rem; color: #9ca3af; border: none; background: none; cursor: pointer; transition: all 0.15s;"
                    onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#111827';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af';"
                >
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem;">
                <template x-for="day in ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']" :key="day">
                    <div style="text-align: center; font-size: 0.75rem; font-weight: 500; color: #6b7280;" x-text="day"></div>
                </template>

                <template x-for="(day, index) in calendarDays" :key="index">
                    <button
                        type="button"
                        @click="day.isCurrentMonth && toggleDate(day.date)"
                        :disabled="!day.isCurrentMonth"
                        :style="{
                            backgroundColor: day.status === 'available' && day.isCurrentMonth ? '#dcfce7' :
                                           day.status === 'unavailable' && day.isCurrentMonth ? '#fee2e2' :
                                           day.status === 'confirm' && day.isCurrentMonth ? '#fef3c7' : 'transparent',
                            color: day.status === 'available' && day.isCurrentMonth ? '#14532d' :
                                   day.status === 'unavailable' && day.isCurrentMonth ? '#7f1d1d' :
                                   day.status === 'confirm' && day.isCurrentMonth ? '#713f12' :
                                   !day.isCurrentMonth ? '#d1d5db' : '#1f2937',
                            cursor: day.isCurrentMonth ? 'pointer' : 'not-allowed',
                            border: 'none'
                        }"
                        style="display: flex; align-items: center; justify-content: center; height: 2.5rem; font-size: 0.875rem; border-radius: 0.25rem; transition: all 0.15s;"
                        x-text="day.day"
                    ></button>
                </template>
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem; font-size: 0.75rem; color: #4b5563; margin-top: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="height: 1rem; width: 1rem; border-radius: 0.25rem; border: 1px solid #bbf7d0; background-color: #dcfce7;"></div>
                <span>Available</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="height: 1rem; width: 1rem; border-radius: 0.25rem; border: 1px solid #fecaca; background-color: #fee2e2;"></div>
                <span>Unavailable</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="height: 1rem; width: 1rem; border-radius: 0.25rem; border: 1px solid #fde68a; background-color: #fef3c7;"></div>
                <span>Need to confirm</span>
            </div>
        </div>
    </div>
</x-dynamic-component>
